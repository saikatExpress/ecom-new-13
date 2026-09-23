<?php

namespace App\Services\Order;

use App\Enums\OrderStatusEnum;
use App\Enums\StatusEnum;
use App\Exceptions\CustomException;
use App\Helpers\Order\InvoiceHelper;
use App\Helpers\Order\PathaoHelper;
use App\Helpers\Order\SteadfastHelper;
use App\Models\Order\Order;
use App\Models\Order\OrderStatus;
use App\Models\Order\Status;
use App\Models\Product\Product;
use App\Models\Product\ProductVariant;
use Illuminate\Support\Facades\DB;
use Throwable;

class OrderService
{
    public function __construct(protected Order $model){}

    public function index($request)
    {
        $paginateSize  = (int) $request->input('paginate_size', 25);
        $paginateSize  = min(max($paginateSize, 1), 100);
        $searchKey     = trim($request->input('search_key', ''));
        $sortBy        = $request->input('sort_by', 'id');
        $sortDirection = strtolower($request->input('sort_direction', 'desc'));

        $allowedSorts = [
            'id',
            'order_date',
            'invoice_number',
            'customer_name',
            'phone_number',
            'total_payable_amount',
            'due',
            'created_at',
        ];

        if (!in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'id';
        }

        if (!in_array($sortDirection, ['asc', 'desc'], true)) {
            $sortDirection = 'desc';
        }

        $query = $this->model->query();

        $query
        ->when($searchKey !== '', function ($query) use ($searchKey) {
            $query->where(function ($query) use ($searchKey) {
                $query
                ->where('invoice_number', 'like', "%{$searchKey}%")
                ->orWhere('customer_name', 'like', "%{$searchKey}%")
                ->orWhere('phone_number', 'like', "%{$searchKey}%");
            });
        })

        ->when($request->filled('status_id'),fn ($query) => $query->where('status_id', $request->status_id))

        ->when($request->filled('paid_status'), fn ($query) => $query->where('paid_status', $request->paid_status))

        ->when($request->filled('customer_type_id'), fn ($query) => $query->where('customer_type_id', $request->customer_type_id))

        ->when($request->filled('delivery_gateway_id'),fn ($query) => $query->where('delivery_gateway_id', $request->delivery_gateway_id))

        ->when($request->filled('payment_gateway_id'), fn ($query) => $query->where('payment_gateway_id', $request->payment_gateway_id))

        ->when($request->filled('district_id'), fn ($query) => $query->where('district_id', $request->district_id))

        ->when($request->filled('courier_id'), fn ($query) => $query->where('courier_id', $request->courier_id))

        ->when($request->filled('courier_status'), fn ($query) => $query->where('courier_status', $request->courier_status))

        ->when($request->filled('assign_user_id'), fn ($query) => $query->where('assign_user_id', $request->assign_user_id))

        ->when($request->filled('prepared_by'), fn ($query) => $query->where('prepared_by', $request->prepared_by))

        ->when($request->filled('is_duplicate'), fn ($query) => $query->where('is_duplicate', filter_var($request->is_duplicate,FILTER_VALIDATE_BOOLEAN)))

        ->when($request->filled('date_from'), fn ($query) => $query->whereDate('order_date','>=', $request->date_from))

        ->when($request->filled('date_to'),fn ($query) => $query->whereDate('order_date','<=', $request->date_to))

        ->when($request->filled('min_amount'), fn ($query) => $query->where('total_payable_amount', '>=', $request->min_amount))

        ->when($request->filled('max_amount'),fn ($query) => $query->where('total_payable_amount', '<=', $request->max_amount));

        $orders = (clone $query)
        ->with([
            'details',
            'currentStatus:id,name',
            'customerType:id,name',
            'orderSource:id,name,color_code',
            'deliveryGateway:id,name',
            'paymentGateway:id,name',
            'district:id,district_name',
            'courier:id,name',
            'assignUser:id,username',
            'preparedBy:id,username',
            'createdBy:id,username',
            'updatedBy:id,username',
        ])
        ->orderBy($sortBy, $sortDirection)
        ->paginate($paginateSize);


        $statusSummary = (clone $query)
        ->select(['status_id',DB::raw('COUNT(*) as total_orders'),DB::raw('SUM(total_payable_amount) as total_payable_amount')])
        ->groupBy('status_id')
        ->get()
        ->keyBy('status_id');

        $statuses = Status::query()
        ->select('id', 'name', 'bg_color', 'text_color', 'icon')
        ->get()
        ->map(function ($status) use ($statusSummary) {

            $summary = $statusSummary->get($status->id);

            return [
                'id'                   => $status->id,
                'name'                 => $status->name,
                'bg_color'             => $status->bg_color,
                'text_color'           => $status->text_color,
                'icon'                 => $status->icon,
                'total_orders'         => $summary ? (int) $summary->total_orders : 0,
                'total_payable_amount' => $summary ? (float) $summary->total_payable_amount : 0,
            ];
        })
        ->values();

        return [
            'orders' => $orders,
            'statuses' => $statuses,
        ];
    }
    public function trashList($request)
    {
        $paginateSize  = (int) $request->input('paginate_size', 25);
        $paginateSize  = min(max($paginateSize, 1), 100);
        $searchKey     = trim($request->input('search_key', ''));
        $sortBy        = $request->input('sort_by', 'deleted_at');
        $sortDirection = strtolower($request->input('sort_direction', 'desc'));

        $allowedSorts = [
            'id',
            'invoice_number',
            'customer_name',
            'phone_number',
            'order_date',
            'deleted_at',
            'total_payable_amount',
        ];

        if (!in_array($sortBy, $allowedSorts, true)) {
            $sortBy = 'deleted_at';
        }

        if (!in_array($sortDirection, ['asc', 'desc'], true)) {
            $sortDirection = 'desc';
        }

        $orders = $this->model
        ->onlyTrashed()
        ->when($searchKey !== '', function ($query) use ($searchKey) {
            $query->where(function ($query) use ($searchKey) {
                $query
                ->where('invoice_number', 'like', "%{$searchKey}%")
                ->orWhere('customer_name', 'like', "%{$searchKey}%")
                ->orWhere('phone_number', 'like', "%{$searchKey}%");
            });
        })
        ->when($request->filled('status_id'),fn ($query) => $query->where('status_id', $request->status_id))

        ->when($request->filled('paid_status'), fn ($query) => $query->where('paid_status', $request->paid_status))

        ->when($request->filled('customer_type_id'), fn ($query) => $query->where('customer_type_id', $request->customer_type_id))

        ->when($request->filled('delivery_gateway_id'), fn ($query) => $query->where('delivery_gateway_id', $request->delivery_gateway_id))

        ->when($request->filled('payment_gateway_id'), fn ($query) => $query->where('payment_gateway_id', $request->payment_gateway_id))

        ->when($request->filled('district_id'),fn ($query) => $query->where('district_id', $request->district_id))

        ->when($request->filled('courier_id'), fn ($query) => $query->where('courier_id', $request->courier_id))

        ->when($request->filled('is_duplicate'), fn ($query) => $query->where('is_duplicate', filter_var($request->is_duplicate,FILTER_VALIDATE_BOOLEAN)))

        ->when($request->filled('deleted_from'),fn ($query) => $query->whereDate('deleted_at', '>=', $request->deleted_from))

        ->when($request->filled('deleted_to'), fn ($query) => $query->whereDate('deleted_at', '<=', $request->deleted_to))

        ->when($request->filled('date_from'), fn ($query) =>$query->whereDate('order_date', '>=', $request->date_from))

        ->when($request->filled('date_to'),fn ($query) => $query->whereDate('order_date', '<=', $request->date_to))

        ->with([
            'currentStatus:id,name',
            'customerType:id,name',
            'deliveryGateway:id,name',
            'paymentGateway:id,name',
            'district:id,district_name',
            'courier:id,name',
            'assignUser:id,username',
            'preparedBy:id,username',
            'createdBy:id,username',
            'updatedBy:id,username',
            'deletedBy:id,username',
        ])

        ->orderBy($sortBy, $sortDirection)

        ->paginate($paginateSize);

        return $orders;
    }

    public function history($request)
    {
        $history = OrderStatus::with(['updatedBy:id,username', 'status:id,name'])->where('order_id', $request->order_id)->get();

        return $history;
    }

    public function store($request)
    {
        return DB::transaction(function() use ($request) {
            $existingOrder = $this->model->where('idempotency_key', $request->idempotency_key)->first();

            if ($existingOrder) {
                throw new CustomException("Order Already Created");
            }

            $order = new $this->model();

            $order->status_id           = $request->status_id;
            $order->customer_type_id    = $request->customer_type_id;
            $order->order_source_id     = $request->order_source_id;
            $order->delivery_gateway_id = $request->delivery_gateway_id;
            $order->payment_gateway_id  = $request->payment_gateway_id;
            $order->coupon_id           = $request->coupon_id;
            $order->courier_id          = $request->courier_id;
            $order->pickup_store_id     = $request->pickup_store_id;
            $order->item_weight         = $request->item_weight;
            $order->district_id         = $request->district_id;
            $order->idempotency_key     = $request->idempotency_key;
            $order->invoice_number      = InvoiceHelper::generate();
            $order->ip_address          = $request->ip();
            $order->utm_source          = $request->utm_source;
            $order->note                = $request->note;
            $order->order_date          = now();
            $order->customer_name       = $request->customer_name;
            $order->phone_number        = $request->phone_number;
            $order->shipping_address    = $request->shipping_address;
            $order->additional_cost     = $request->input('additional_cost', 0);
            $order->advanced_payment    = $request->input('advanced_payment', 0);
            $order->special_discount    = $request->input('special_discount', 0);
            $order->coupon_discount     = $request->input('coupon_discount', 0);
            $order->delivery_charge     = $request->input('delivery_charge', 0);

            $order->save();

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

            $totalPayableAmount = $netOrderAmount - $order->special_discount - $order->coupon_discount + $order->delivery_charge;

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

            return $order;
        });
    }
    public function statusUpdate($request)
    {
        $ids = collect($request->input('ids', []))->map(fn ($id) => (int) $id)->filter(fn ($id) => $id > 0)->unique()->values()->toArray();

        $statusId = (int) $request->input('status_id');

        if (empty($ids)) {
            throw new CustomException('Please provide at least one order ID.');
        }

        if (!$statusId) {
            throw new CustomException('Please provide a valid status ID.');
        }

        $status = Status::query()->select('id', 'name')->find($statusId);

        if (!$status) {
            throw new CustomException('Invalid order status.');
        }

        $orders = $this->model->whereIn('id', $ids)->orderBy('id')->get();

        if ($orders->isEmpty()) {
            throw new CustomException('No orders found.');
        }

        $updated = [];
        $skipped = [];
        $failed  = [];

        foreach ($orders as $order) {

            try {
                $result = $this->updateSingleOrderStatus($order->id, $statusId);

                return $result;

                if ($result['action'] === 'updated') {
                    $updated[] = $result;
                } else {
                    $skipped[] = $result;
                }

            } catch (Throwable $e) {
                report($e);

                $failed[] = [
                    'order_id' => $order->id,
                    'message' => $e->getMessage(),
                ];
            }
        }

        $foundIds = $orders->pluck('id')->map(fn ($id) => (int) $id)->toArray();

        $missingIds = array_values(array_diff($ids, $foundIds));

        foreach ($missingIds as $missingId) {
            $failed[] = [
                'order_id' => $missingId,
                'message' => 'Order Not Found.',
            ];
        }

        return [
            'updated'       => $updated,
            'skipped'       => $skipped,
            'failed'        => $failed,
            'updated_count' => count($updated),
            'skipped_count' => count($skipped),
            'failed_count'  => count($failed),
        ];
    }

    protected function updateSingleOrderStatus($orderId, int $statusId)
    {
        return DB::transaction(function () use ($orderId, $statusId) {

            $order = $this->model->lockForUpdate()->find($orderId);

            if (!$order) {
                throw new CustomException('Order Not Found.');
            }

            if ((int) $order->status_id === OrderStatusEnum::CANCELED) {

                return [
                    'action'   => 'skipped',
                    'order_id' => $order->id,
                    'message'  => 'Order is already in canceled status and cannot be updated.',
                ];
            }

            if ((int) $order->status_id === $statusId) {

                return [
                    'action'   => 'skipped',
                    'order_id' => $order->id,
                    'message'  => 'Order is already in this status.',
                ];
            }

            $additionalData = $this->handleStatusAction($order, $statusId);

            return $additionalData;

            $order->status_id = $statusId;

            return $order;

            if (!empty($additionalData)) {
                $order->fill($additionalData);
            }

            $order->save();

            $order->statuses()->create(['status_id' => $statusId]);

            return [
                'action'    => 'updated',
                'order_id'  => $order->id,
                'status_id' => $statusId,
            ];
        });
    }

    protected function handleStatusAction(Order $order, int $statusId): array
    {
        $handlers = [

            OrderStatusEnum::IN_COURIER => 'handleInCourier',

            // Future:
            OrderStatusEnum::DELIVERED => 'handleDelivered',

            OrderStatusEnum::RETURNED => 'handleReturned',
        ];


        $handler = $handlers[$statusId] ?? null;

        if (!$handler) {
            return [];
        }

        return $this->{$handler}($order);
    }

    protected function handleInCourier(Order $order): array
    {

        if (!$order->courier_id) {
            throw new CustomException("Courier is not selected for order #{$order->id}.");
        }

        if ($order->consignment_id) {
            throw new CustomException("Order #{$order->id} is already entered into courier.");
        }

        if($order->courier_id == 1){
            $pathao = new PathaoHelper();
            $result = $pathao->createOrder($order->id);
        }

        if($order->courier_id == 2){
            $steadfast = new SteadfastHelper();

            $result = $steadfast->createOrder($order->id);
        }

        if (!($result['success'] ?? false)) {
            throw new CustomException($result['message'] ?? "Failed to create courier entry for order #{$order->id}.");
        }

        return [
            'courier_status'    => $result['courier_status'] ?? 'pending',
            'consignment_id'    => $result['consignment_id'] ?? null,
            'tracking_code'     => $result['tracking_code'] ?? null,
            'callback_response' => $result['response'] ?? $result,
        ];
    }

    public function show($id)
    {
        $order = $this->model
        ->with([
            'currentStatus',
            'details',
            'notes.createdBy',
            'statuses.status',
            'statuses.createdBy',
            'customerType',
            'deliveryGateway',
            'paymentGateway',
            'coupon',
            'cancelReason',
            'assignUser',
            'preparedBy',
            'lockedBy',
            'district',
            'courier',
            'createdBy',
            'updatedBy',
            'deletedBy',
        ])
        ->find($id);

        if(!$order){
            throw new CustomException("Order Not Found");
        }

        return $order;
    }

    public function update($request, $id)
    {
        return DB::transaction(function () use ($request, $id) {

            $order = $this->model::query()->lockForUpdate()->find($id);

            if ($request->filled('idempotency_key') && $order->idempotency_key === $request->idempotency_key) {
                throw new CustomException('This order has already been updated.');
            }

            if (!$order) {
                throw new CustomException('Order Not Found');
            }

            $data = $request->validated();

            $oldStatusId = $order->status_id;

            $oldDetails = $order->details()->lockForUpdate()->get();

            foreach ($oldDetails as $detail) {

                if ($detail->product_variant_id) {
                    $variant = ProductVariant::query()->lockForUpdate()->find($detail->product_variant_id);

                    if ($variant) {
                        $variant->increment('current_stock',$detail->quantity);
                        $variant->decrement('total_sell_quantity',$detail->quantity);
                    }
                }

                if ($detail->product_id) {
                    $product = Product::query()->lockForUpdate()->find($detail->product_id);

                    if ($product) {
                        $product->increment('current_stock',$detail->quantity);

                        $product->decrement('total_sell_quantity',$detail->quantity);
                    }
                }
            }

            $order->details()->delete();

            $order->fill([
                'status_id'           => $data['status_id'],
                'customer_type_id'    => $data['customer_type_id'] ?? null,
                'order_source_id'     => $data['order_source_id'] ?? null,
                'delivery_gateway_id' => $data['delivery_gateway_id'] ?? null,
                'payment_gateway_id'  => $data['payment_gateway_id'] ?? null,
                'coupon_id'           => $data['coupon_id'] ?? null,
                'cancel_reason_id'    => $data['cancel_reason_id'] ?? null,
                'assign_user_id'      => $data['assign_user_id'] ?? null,
                'prepared_by'         => $data['prepared_by'] ?? null,
                'locked_by_id'        => $data['locked_by_id'] ?? null,
                'district_id'         => $data['district_id'] ?? null,
                'courier_id'          => $data['courier_id'] ?? null,
                'pickup_store_id'     => $data['pickup_store_id'] ?? null,
                'customer_name'       => $data['customer_name'],
                'phone_number'        => $data['phone_number'],
                'shipping_address'    => $data['shipping_address'],
                'ip_address'          => $data['ip_address'] ?? $order->ip_address,
                'utm_source'          => $data['utm_source'] ?? null,
                'note'                => $data['note'] ?? null,
                'additional_cost'     => $data['additional_cost'] ?? 0,
                'advanced_payment'    => $data['advanced_payment'] ?? 0,
                'special_discount'    => $data['special_discount'] ?? 0,
                'coupon_discount'     => $data['coupon_discount'] ?? 0,
                'delivery_charge'     => $data['delivery_charge'] ?? 0,
                'delivery_type'       => $data['delivery_type'] ?? 48,
                'courier_status'      => $data['courier_status'] ?? null,
                'consignment_id'      => $data['consignment_id'] ?? null,
                'tracking_code'       => $data['tracking_code'] ?? null,
                'item_weight'         => $data['item_weight'] ?? null,
                'paid_status'         => $data['paid_status'] ?? $order->paid_status,
                'status'              => $data['status'] ?? $order->status,
            ]);

            $totalBuyPrice  = 0;
            $totalMrp       = 0;
            $totalDiscount  = 0;
            $totalSellPrice = 0;

            foreach ($data['items'] as $item) {

                $product = Product::query()->lockForUpdate()->find($item['product_id']);

                if (!$product) {
                    throw new CustomException("Product not found: {$item['product_id']}");
                }

                $variant = null;

                if (!empty($item['product_variant_id'])) {

                    $variant = $product->variants()->with('attributeValues.attribute')->lockForUpdate()->find($item['product_variant_id']);

                    if (!$variant) {
                        throw new CustomException("Selected variant does not belong to product {$product->name}");
                    }

                    if ($variant->current_stock < $item['quantity']) {
                        throw new CustomException("Insufficient stock for {$product->name}");
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

                    $variant->increment('total_sell_quantity', $item['quantity']);
                }else {
                    $hasActiveVariants = $product->variants()->where('status',StatusEnum::ACTIVE)->exists();

                    if ($hasActiveVariants) {
                        throw new CustomException("Product {$product->name} requires a variant.");
                    }

                    if ($product->current_stock < $item['quantity']) {
                        throw new CustomException("Insufficient stock for {$product->name}");
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

                $order->details()->create([
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
                    'discount'           => $discount,
                    'sell_price'         => $sellPrice,
                    'profit'             => $lineProfit,
                ]);

                $totalBuyPrice  += $lineBuyPrice;
                $totalMrp       += $lineMrp;
                $totalDiscount  += $lineDiscount;
                $totalSellPrice += $lineSellPrice;
            }

            $netOrderAmount = $totalSellPrice;

            $totalPayableAmount = $netOrderAmount - $order->special_discount - $order->coupon_discount + $order->delivery_charge;

            $due = max($totalPayableAmount - $order->advanced_payment,0);

            $order->buy_price            = $totalBuyPrice;
            $order->mrp                  = $totalMrp;
            $order->discount             = $totalDiscount;
            $order->sell_price           = $totalSellPrice;
            $order->net_order_amount     = $netOrderAmount;
            $order->total_payable_amount = $totalPayableAmount;
            $order->due                  = $due;

            $order->save();

            if ((int) $oldStatusId !== (int) $order->status_id) {
                $order->statuses()->create(['status_id' => $order->status_id]);
            }

            return $order;
        });
    }

    public function searchByPhoneNumber($request)
    {
        $phoneNumber = $request->input("phone_number", null);

        $orders = $this->model
            ->select(
                "id",
                "courier_id",
                "district_id",
                "customer_type_id",
                "delivery_charge",
                "phone_number",
                "customer_name",
                "shipping_address",
                "pickup_store_id",
                "delivery_type",
                "item_weight"
            )
            ->where("phone_number", $phoneNumber)
            ->latest()
            ->first();

        return $orders;
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {

            $order = $this->model::query()->find($id);

            if (!$order) {
                throw new CustomException('Order Not Found');
            }

            $order->delete();

            return true;
        });
    }

    public function restore($id)
    {
        return DB::transaction(function () use ($id) {

            $order = $this->model::onlyTrashed()->find($id);

            if (!$order) {
                throw new CustomException('Trashed Order Not Found');
            }

            $order->restore();

            return $order->fresh([
                'currentStatus',
                'details',
                'notes.createdBy',
                'statuses.status',
                'statuses.createdBy',
                'customerType',
                'deliveryGateway',
                'paymentGateway',
                'coupon',
                'cancelReason',
                'assignUser',
                'preparedBy',
                'lockedBy',
                'district',
                'courier',
                'createdBy',
                'updatedBy',
                'deletedBy',
            ]);
        });
    }

    public function permanentDelete($id)
    {
        return DB::transaction(function () use ($id) {

            $order = $this->model::onlyTrashed()->find($id);

            if (!$order) {
                throw new CustomException('Trashed Order Not Found');
            }

            $order->forceDelete();

            return true;
        });
    }
}
