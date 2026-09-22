<?php

namespace App\Helpers\Order;

use App\Enums\OrderStatusEnum;
use App\Exceptions\CustomException;
use App\Models\Order\Order;
use Illuminate\Support\Facades\Http;

class SteadfastHelper
{
    private $endPoint;
    private $apiKey;
    private $secretKey;
    private $headers;

    public function __construct()
    {
        $this->endPoint  = config("stead_fast.endpoint");
        $this->apiKey    = config("stead_fast.api_key");
        $this->secretKey = config("stead_fast.secret_key");
        $this->headers   = $this->getHeaders();
    }

    public function createOrder($orderId)
    {
        if (!env("STEAD_FAST_API_KEY") || !env("STEAD_FAST_SECRET_KEY")) {
            throw new CustomException("Stead fast credential not configured");
        }

        $order = Order::where("courier_id", 1)->where("id", $orderId)->first();

        if (!$order) {
            throw new CustomException("Invalid steadfast courier information for order id $orderId");
        }

        $codAmount = $order->payable_price;

        if ($order->advance_payment > 0) {
            $codAmount -= $order->advance_payment;
        }

        $codAmount = max(0, $codAmount);

        $body = [
            'invoice'           => $orderId,
            'recipient_name'    => $order->customer_name,
            'recipient_phone'   => $order->phone_number,
            'recipient_address' => $order->address_details,
            'cod_amount'        => round($codAmount),
            'note'              => $order->note
        ];

        $url = "$this->endPoint/create_order";

        $res = Http::withHeaders($this->headers)->post($url, $body);

        $res = json_decode($res, true);

        // Check error
        if ($res["status"] === 400) {
            $error = "Error from stead fast";
            $error = @$res["errors"]["invoice"];

            throw new CustomException($error);
        }

        // Update order information
        if ($res["status"] === 200) {
            $order->consignment_id    = @$res["consignment"]["consignment_id"];
            $order->tracking_code     = @$res["consignment"]["tracking_code"];
            $order->courier_status_id = OrderStatusEnum::COURIER_PENDING;
            $order->save();
        }

        return $res;
    }

    public function bulkCreate($request)
    {
        if (!env("STEAD_FAST_API_KEY") || !env("STEAD_FAST_SECRET_KEY")) {
            throw new CustomException("Stead fast credential not configured");
        }

        $orders = Order::where("courier_id", 1)->whereIn("id", $request->order_ids)->get();

        $data = [];

        foreach ($orders as $order) {
            $codAmount = $order->payable_price;

            if ($order->advance_payment > 0) {
                $codAmount -= $order->advance_payment;
            }

            $codAmount = max(0, $codAmount);

            $data[] = [
                'invoice'           => $order->id,
                'recipient_name'    => $order->customer_name,
                'recipient_address' => $order->address_details,
                'recipient_phone'   => $order->phone_number,
                'cod_amount'        => round($codAmount),
                'note'              => $order->note,
            ];
        }

        $url = "$this->endPoint/create_order/bulk-order";

        $res = Http::withHeaders($this->headers)->post($url, $data);

        $response = $res->json();

        foreach ($response['data'] as $item) {
            $order = Order::where('id', $item['invoice'])->first();

            if ($order) {
                $order->consignment_id    = $item['consignment_id'];
                $order->tracking_code     = $item['tracking_code'];
                $order->courier_status_id = OrderStatusEnum::COURIER_PENDING;
                $order->save();
            }
        }

        return true;
    }

    public function getDeliveryStatus($invoiceId)
    {
        $url = "{$this->endPoint}/status_by_invoice/{$invoiceId}";

        $res = Http::withHeaders($this->headers)->get($url);

        $jsonRes = json_decode($res, true);

        return $jsonRes;
    }

    public function getCurrentBalance()
    {
        $url = "$this->endPoint/get_balance";

        $res = Http::withHeaders($this->headers)->get($url);

        $jsonRes = json_decode($res, true);

        return $jsonRes;
    }

    private function getHeaders()
    {
        return [
            "Api-Key"      => $this->apiKey,
            "Secret-Key"   => $this->secretKey,
            "Accept"       => "application/json",
            "Content-Type" => "application/json"
        ];
    }

    public function callback($request)
    {
        $steadFastStatus = $request->status ?? NULL;

        $order = Order::where("consignment_id", $request->consignment_id)
        ->orWhere("id", $request->invoice)
        ->first();

        if (!$order) {
            throw new CustomException("Callback order not found");
        }

        if ($steadFastStatus == "Delivered" || $steadFastStatus == "delivered") {
            $order->current_status_id = OrderStatusEnum::DELIVERED;
            $order->courier_status_id = OrderStatusEnum::DELIVERED;
        } else if ($steadFastStatus == "partial_delivered") {
            $order->current_status_id = OrderStatusEnum::PARTIAL_RETURNED;
            $order->courier_status_id = OrderStatusEnum::PARTIAL_RETURNED;
        } else if ($steadFastStatus == "cancelled") {
            $order->current_status_id = OrderStatusEnum::CANCELED;
            $order->courier_status_id = OrderStatusEnum::RETURNED;
        } else if ($steadFastStatus == "pending") {
            $order->courier_status_id = OrderStatusEnum::COURIER_RECEIVED;
        }

        $existingResponses = $order->callback_response ?? [];
        if (!is_array($existingResponses)) {
            $existingResponses = json_decode($existingResponses, true) ?? [];
        }

        $existingResponses[] = [
            "notification_type" => $request->notification_type,
            "consignment_id"    => $request->consignment_id,
            "invoice"           => $request->invoice,
            "status"            => $steadFastStatus,
            "cod_amount"        => $request->cod_amount ?? 0,
            "delivery_charge"   => $request->delivery_charge ?? 0,
            "updated_at"        => $request->updated_at,
            "note"              => $request->tracking_message
        ];

        $order->callback_response = $existingResponses;

        if(!$order->courier_payable){
            $order->courier_payable   = $request->delivery_charge ?? 0;
        }

        $order->save();

        return true;
    }
}
