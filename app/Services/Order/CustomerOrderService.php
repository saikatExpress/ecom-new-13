<?php

namespace App\Services\Order;

use App\Enums\OrderStatusEnum;
use App\Enums\StatusEnum;
use App\Exceptions\CustomException;
use App\Helpers\Order\InvoiceHelper;
use App\Helpers\Setting\SettingHelper;
use App\Models\Order\Courier;
use App\Models\Order\CustomerType;
use App\Models\Order\DeliveryGateway;
use App\Models\Order\Order;
use App\Models\Product\Product;
use App\Services\Order\OrderGuardService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomerOrderService
{
    public function __construct(protected Order $model,protected OrderGuardService $orderGuardService){}

    public function store($request)
    {
        if (!$request->filled('idempotency_key')) {
            throw new CustomException('Idempotency key is required. Please refresh checkout and try again.');
        }

        if (!Str::isUuid($request->idempotency_key)) {
            throw new CustomException('Invalid idempotency key.');
        }

        $existingOrder = $this->model->where('idempotency_key', $request->idempotency_key)->first();

        if ($existingOrder) {
            throw new CustomException("Oder Already Created");
        }

        $guardContext = $this->orderGuardService->check($request);

        return DB::transaction(function() use ($request, $guardContext) {
            $order = new $this->model();

            $duplicateOrderDuration = 0;

            $previousOrderCount = $this->model::where('phone_number', $request->phone_number)->count();
            $customerType       = CustomerType::where('order_range', '<=', $previousOrderCount)->orderByDesc('order_range')->first();
            $deliveryGateway    = DeliveryGateway::findOrFail($request->delivery_gateway_id);

            $settingValue = SettingHelper::setting('duplicate_order_duration');

            if (is_numeric($settingValue)) {
                $duplicateOrderDuration = max(0, (int) $settingValue);
            }

            $isDuplicate = false;

            if ($duplicateOrderDuration > 0) {

                $cutoffTime = now()->subMinutes($duplicateOrderDuration);

                $isDuplicate = $this->model->where('phone_number', $request->phone_number)->where('order_date', '>=', $cutoffTime)->exists();
            }

            $order->status_id           = OrderStatusEnum::NEW_ORDER;
            $order->customer_type_id    = $customerType?->id;
            $order->order_source_id     = 1;
            $order->invoice_number      = InvoiceHelper::generate();
            $order->idempotency_key     = $request->idempotency_key;
            $order->delivery_gateway_id = $deliveryGateway->id;
            $order->delivery_charge     = $deliveryGateway->delivery_fee;
            $order->courier_id          = Courier::where('is_default', 1)->value('id') ?? null;;
            $order->item_weight         = .5;
            $order->payment_gateway_id  = $request->payment_gateway_id;
            $order->customer_name       = Str::title($request->customer_name);
            $order->phone_number        = $request->phone_number;
            $order->paid_status         = StatusEnum::UNPAID->value;
            $order->shipping_address    = Str::title($request->shipping_address);
            $order->ip_address          = $request->ip();
            $order->utm_source          = $request->utm_source ?? NULL;
            $order->coupon_id           = $request->coupon_id ?? NULL;
            $order->status              = StatusEnum::ACTIVE->value;
            $order->is_duplicate        = $isDuplicate;
            $order->order_date          = now();

            $order->save();

            $order->guardDetails()->create($guardContext);

            $totalBuyPrice  = 0;
            $totalMrp       = 0;
            $totalDiscount  = 0;
            $totalSellPrice = 0;
            $totalProfit    = 0;

            foreach ($request->items as $item) {

                $product = Product::query()->with('variants.attributeValues.attribute')->lockForUpdate()->findOrFail($item['product_id']);

                $variant = null;

                if (!empty($item['product_variant_id'])) {

                    $variant = $product->variants()->with('attributeValues.attribute')->lockForUpdate()->find($item['product_variant_id']);

                    if (!$variant) {
                        throw new CustomException("The selected variant does not belong to product {$product->id}.");
                    }

                    if ($variant->current_stock < $item['quantity']) {
                        throw new CustomException("Insufficient stock for {$product->name}.");
                    }

                    $buyPrice  = $variant->buy_price ?? 0;
                    $mrp       = $variant->mrp;
                    $sellPrice = (!is_null($variant->offer_price) && $variant->offer_price > 0) ? $variant->offer_price : $variant->sell_price;
                    $discount  = $variant->discount_amount ?? 0;

                    $variantOptions = [];

                    foreach ($variant->attributeValues as $attributeValue) {
                        if ($attributeValue->attribute) {
                            $variantOptions[$attributeValue->attribute->name] = $attributeValue->value;
                        }
                    }

                    $variantName = collect($variantOptions)->map(fn ($value, $key) => "{$key}: {$value}")->implode(', ');

                    $variant->decrement('current_stock', $item['quantity']);

                    $variant->increment('total_sell_quantity',$item['quantity']);

                } else {
                    if ($product->variants()->where('status', StatusEnum::ACTIVE)->exists()) {
                        throw new CustomException("Product {$product->name} requires a variant.");
                    }

                    if ($product->current_stock < $item['quantity']) {
                        throw new CustomException("Insufficient stock for {$product->name}.");
                    }

                    $buyPrice  = $product->buy_price ?? 0;
                    $mrp       = $product->mrp;
                    $sellPrice = (!is_null($product->offer_price) && $product->offer_price > 0) ? $product->offer_price : $product->sell_price;
                    $discount  = $product->discount_amount ?? 0;

                    $variantOptions = null;
                    $variantName = null;

                    $product->decrement('current_stock',$item['quantity']);
                }

                $product->increment('total_sell_quantity',$item['quantity']);

                $quantity = $item['quantity'];

                $lineBuyPrice  = $buyPrice * $quantity;
                $lineMrp       = $mrp * $quantity;
                $lineDiscount  = $discount * $quantity;
                $lineSellPrice = $sellPrice * $quantity;
                $lineProfit    = $lineSellPrice - $lineBuyPrice;

                $detail = $order->details()->create([
                    'product_id'         => $product->id,
                    'product_variant_id' => $variant?->id,
                    'product_name'       => $product->name,
                    'product_sku'        => $product->sku,
                    'product_img_path'   => $product->img_path,
                    'variant_name'       => $variantName,
                    'variant_sku'        => $variant?->sku,
                    'variant_options'    => $variantOptions,
                    'quantity'           => $quantity,
                    'buy_price'          => $buyPrice,
                    'mrp'                => $mrp,
                    'sell_price'         => $sellPrice,
                    'discount'           => $discount,
                    'profit'             => $lineProfit,
                ]);

                $totalBuyPrice  += $lineBuyPrice;
                $totalMrp       += $lineMrp;
                $totalDiscount  += $lineDiscount;
                $totalSellPrice += $lineSellPrice;
                $totalProfit    += $lineProfit;
            }

            $netOrderAmount = $totalSellPrice;

            $totalPayableAmount = $netOrderAmount - $order->special_discount - $order->coupon_discount + $order->delivery_charge + $order->additional_cost;

            $due = max($totalPayableAmount - $order->advanced_payment,0);

            $order->update([
                'buy_price'            => $totalBuyPrice,
                'mrp'                  => $totalMrp,
                'discount'             => $totalDiscount,
                'sell_price'           => $totalSellPrice,
                'net_order_amount'     => $netOrderAmount,
                'total_payable_amount' => $totalPayableAmount,
                'due'                  => $due,
                'paid_status'          => $order->advanced_payment > 0 ? StatusEnum::PAID : StatusEnum::UNPAID,
            ]);

            $order->statuses()->create(['status_id' => $order->status_id]);

            $this->orderGuardService->recordAllowed($guardContext,$order->id);

            return $order;
        });
    }

    public function show($request,$id)
    {
        $order = $this->model
        ->with([
            'details',
            'currentStatus:id,name',
            'customerType:id,name',
            'orderSource:id,name,color_code',
            'deliveryGateway:id,name',
            'paymentGateway:id,name',
            'courier:id,name',
        ])
        ->where('ip_address', $request->ip())->where('phone_number', $request->phone_number)->where('id', $id)->first();

        if(!$order){
            throw new CustomException("Order Not Found");
        }

        return $order;
    }
}
