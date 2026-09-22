<?php

namespace App\Services\Order;

use App\Enums\OrderStatusEnum;
use App\Enums\StatusEnum;
use App\Exceptions\CustomException;
use App\Models\Order\Courier;
use App\Models\Order\CustomerType;
use App\Models\Order\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CustomerOrderService
{
    public function __construct(protected Order $model){}

    public function store($request)
    {
        return DB::transaction(function() use ($request) {
            $order = new $this->model();

            $previousOrderCount = Order::where('phone_number', $request->phone_number)->count();
            $customerType       = CustomerType::where('order_range', '<=', $previousOrderCount)->orderByDesc('order_range')->first();

            $order->status_id           = OrderStatusEnum::NEW_ORDER;
            $order->customer_type_id    = $customerType?->id;
            $order->idempotency_key     = $request->idempotency_key;
            $order->delivery_gateway_id = $request->delivery_gateway_id;
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
            $order->order_date          = now();

            $order->save();

            return $order;
        });
    }

    public function show($request,$id)
    {
        $order = $this->model::where('ip_address', $request->ip())->where('phone_number', $request->phone_number)->where('id', $id)->first();

        if(!$order){
            throw new CustomException("Order Not Found");
        }

        return $order;
    }
}
