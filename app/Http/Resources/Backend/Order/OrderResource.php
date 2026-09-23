<?php

namespace App\Http\Resources\Backend\Order;

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
            'cancel_reason_id'     => $this->cancel_reason_id,
            'assign_user_id'       => $this->assign_user_id,
            'prepared_by'          => $this->prepared_by,
            'locked_by_id'         => $this->locked_by_id,
            'district_id'          => $this->district_id,
            'courier_id'           => $this->courier_id,
            'customer_name'        => $this->customer_name,
            'phone_number'         => $this->phone_number,
            'shipping_address'     => $this->shipping_address,
            'utm_source'           => $this->utm_source,
            'pickup_store_id'      => $this->pickup_store_id,
            'invoice_number'       => $this->invoice_number,
            'ip_address'           => $this->ip_address,
            'order_date'           => $this->order_date,
            'prepared_at'          => $this->prepared_at,
            'locked_at'            => $this->locked_at,
            'buy_price'            => $this->buy_price,
            'mrp'                  => $this->mrp,
            'discount'             => $this->discount,
            'sell_price'           => $this->sell_price,
            'additional_cost'      => $this->additional_cost,
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
            'district' => $this->whenLoaded('district', function () {
                return [
                    'id'   => $this->district->id,
                    'name' => $this->district->district_name,
                ];
            }),
            'courier' => $this->whenLoaded('courier', function () {
                return [
                    'id'   => $this->courier->id,
                    'name' => $this->courier->name,
                ];
            }),
            'created_by' => $this->whenLoaded('createdBy', function(){
                return [
                    'id'       => $this->createdBy->id,
                    'username' => $this->createdBy->username,
                ];
            }),
            'updated_by' => $this->whenLoaded('updatedBy', function(){
                return [
                    'id'       => $this->updatedBy->id,
                    'username' => $this->updatedBy->username,
                ];
            }),
            'prepare_by' => $this->whenLoaded('preparedBy', function(){
                return [
                    'id'       => $this->preparedBy->id,
                    'username' => $this->preparedBy->username,
                ];
            }),
            'loacked_by' => $this->whenLoaded('lockedBy', function(){
                return [
                    'id'       => $this->lockedBy->id,
                    'username' => $this->lockedBy->username,
                ];
            }),
            'deleted_by' => $this->whenLoaded('deletedBy', function(){
                return [
                    'id'       => $this->deletedBy->id,
                    'username' => $this->deletedBy->username,
                ];
            }),

            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }
}
