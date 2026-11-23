<?php

namespace App\Http\Resources\Frontend\Order;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'                   => $this->id,
            'status_id'            => $this->status_id,
            'customer_type_id'     => $this->customer_type_id,
            'order_source_id'      => $this->order_source_id,
            'delivery_gateway_id'  => $this->delivery_gateway_id,
            'payment_gateway_id'   => $this->payment_gateway_id,
            'coupon_id'            => $this->coupon_id,
            'courier_id'           => $this->courier_id,
            'customer_name'        => $this->customer_name,
            'phone_number'         => $this->phone_number,
            'shipping_address'     => $this->shipping_address,
            'utm_source'           => $this->utm_source,
            'invoice_number'       => $this->invoice_number,
            'ip_address'           => $this->ip_address,
            'order_date'           => $this->order_date,
            'mrp'                  => $this->mrp,
            'discount'             => $this->discount,
            'sell_price'           => $this->sell_price,
            'net_order_amount'     => $this->net_order_amount,
            'advanced_payment'     => $this->advanced_payment,
            'special_discount'     => $this->special_discount,
            'coupon_discount'      => $this->coupon_discount,
            'delivery_charge'      => $this->delivery_charge,
            'total_payable_amount' => $this->total_payable_amount,
            'due'                  => $this->due,
            'courier_status'       => $this->courier_status,
            'consignment_id'       => $this->consignment_id,
            'tracking_code'        => $this->tracking_code,
            'callback_response'    => $this->callback_response,
            'paid_status'          => $this->paid_status,
            'item_weight'          => $this->item_weight,
            'note'                 => $this->note,
            'status'               => $this->status,

            'details'    => OrderDetailResource::collection($this->whenLoaded('details')),
            'current_status' => $this->whenLoaded('currentStatus', function () {
                return [
                    'id'   => $this->currentStatus->id,
                    'name' => $this->currentStatus->name,
                ];
            }),
            'customer_type' => $this->whenLoaded('customerType', function () {
                return [
                    'id'   => $this->customerType->id,
                    'name' => $this->customerType->name,
                ];
            }),
            'order_source' => $this->whenLoaded('orderSource', function () {
                return [
                    'id'         => $this->orderSource->id,
                    'name'       => $this->orderSource->name,
                    'color_code' => $this->orderSource->color_code,
                ];
            }),
            'delivery_gateway' => $this->whenLoaded('deliveryGateway', function () {
                return [
                    'id'   => $this->deliveryGateway->id,
                    'name' => $this->deliveryGateway->name,
                ];
            }),
            'payment_gateway' => $this->whenLoaded('paymentGateway', function () {
                return [
                    'id'   => $this->paymentGateway->id,
                    'name' => $this->paymentGateway->name,
                ];
            }),
            'courier' => $this->whenLoaded('courier', function () {
                return [
                    'id'   => $this->courier->id,
                    'name' => $this->courier->name,
                ];
            }),
        ];
    }
}
