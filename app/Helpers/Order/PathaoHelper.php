<?php

namespace App\Helpers\Order;

use App\Enums\StatusEnum;
use App\Models\Order\Order;
use App\Enums\OrderStatusEnum;
use App\Exceptions\CustomException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class PathaoHelper
{
    private $endPoint;
    private $clientId;
    private $clientSecret;
    private $username;
    private $password;
    private $grantType;

    public function __construct()
    {
        $this->endPoint     = config("pathao.endpoint");
        $this->clientId     = config("pathao.client_id");
        $this->clientSecret = config("pathao.client_secret");
        $this->username     = config("pathao.username");
        $this->password     = config("pathao.password");
        $this->grantType    = config("pathao.grant_type");
    }

    // Get access token
    public function accessToken()
    {
        $headers = [
            "Accept"       => "application/json",
            "Content-Type" => "application/json"
        ];

        $body = [
            "client_id"     => $this->clientId,
            "client_secret" => $this->clientSecret,
            "username"      => $this->username,
            "password"      => $this->password,
            "grant_type"    => $this->grantType
        ];

        $url = "$this->endPoint/aladdin/api/v1/issue-token";

        $res = Http::withHeaders($headers)->post($url, $body);

        return json_decode($res, true);
    }

    public function headers()
    {
        $data        = $this->accessToken();

        $accessToken = @$data["access_token"];

        return [
            "Authorization" => "Bearer $accessToken",
            "Accept"        => "application/json",
            "Content-Type"  => "application/json"
        ];
    }

    public function refreshToken()
    {
        $headers = [
            "Accept"       => "application/json",
            "Content-Type" => "application/json"
        ];

        $data         = $this->accessToken();
        $refreshToken = @$data["refresh_token"];

        $body = [
            "client_id"     => $this->clientId,
            "client_secret" => $this->clientSecret,
            "refresh_token" => $refreshToken,
            "grant_type"    => "refresh_token"
        ];

        $url = "$this->endPoint/aladdin/api/v1/issue-token";

        $res = Http::withHeaders($headers)->post($url, $body);

        return json_decode($res, true);
    }

    public function createOrder($orderId)
    {
        if (!env("PATHAO_CLIENT_ID") || !env("PATHAO_CLIENT_SECRET")) {
            throw new CustomException("Pathao credential not configured");
        }

        $order = Order::where("courier_id", 2)->where("id", $orderId)->whereNotNull("pickup_store_id")->first();

        if (!$order) {
            throw new CustomException("Invalid pathao courier information for order id $orderId");
        }

        $body = [
            "store_id"            => $order->pickup_store_id,
            "merchant_order_id"   => $order->id,
            "recipient_name"      => $order->customer_name,
            "recipient_phone"     => $order->phone_number,
            "recipient_address"   => $order->address_details,
            "delivery_type"       => $order->delivery_type ?? 48, // Normal delivery
            "item_type"           => 2, // Parcel
            "special_instruction" => "",
            "item_quantity"       => $order->details()->sum("quantity"),
            "item_weight"         => $order->item_weight ?? 0.5,
            "amount_to_collect"   => $order->paid_status == StatusEnum::PAID ? 0 : round($order->payable_price),
            "item_description"    => $order->note,
        ];

        $url = "$this->endPoint/aladdin/api/v1/orders";

        $res = Http::withHeaders($this->headers())->post($url, $body);

        $res = json_decode($res, true);

        if ($res["type"] == "success") {
            // Update order information
            $order->consignment_id    = @$res["data"]["consignment_id"] ?? null;
            $order->courier_payable   = @$res["data"]["delivery_fee"] ?? 0;
            $order->courier_status_id = OrderStatusEnum::COURIER_PENDING;
            $order->save();

            return $res;
        } else {
            $errorMessage = null;
            if (@$res["errors"]["store_id"]) {
                $errorMessage = @$res["errors"]["store_id"][0];
            } elseif (@$res["errors"]["recipient_name"]) {
                $errorMessage = @$res["errors"]["recipient_name"][0];
            } elseif (@$res["errors"]["recipient_phone"]) {
                $errorMessage = @$res["errors"]["recipient_phone"][0];
            } elseif (@$res["errors"]["sender_name"]) {
                $errorMessage = @$res["errors"]["sender_name"][0];
            } elseif (@$res["errors"]["sender_phone"]) {
                $errorMessage = @$res["errors"]["sender_phone"][0];
            } elseif (@$res["errors"]["recipient_city"]) {
                $errorMessage = @$res["errors"]["recipient_city"][0];
            } elseif (@$res["errors"]["recipient_zone"]) {
                $errorMessage = @$res["errors"]["recipient_zone"][0];
            } elseif (@$res["errors"]["recipient_address"]) {
                $errorMessage = @$res["errors"]["recipient_address"][0];
            } elseif (@$res["errors"]["amount_to_collect"]) {
                $errorMessage = @$res["errors"]["amount_to_collect"][0];
            } elseif (@$res["errors"]["item_weight"]) {
                $errorMessage = @$res["errors"]["item_weight"][0];
            } elseif (@$res["errors"]["item_type"]) {
                $errorMessage = @$res["errors"]["item_type"][0];
            } elseif (@$res["errors"]["delivery_type"]) {
                $errorMessage = @$res["errors"]["delivery_type"][0];
            } elseif (@$res["errors"]["item_quantity"]) {
                $errorMessage = @$res["errors"]["item_quantity"][0];
            } else {
                $errorMessage = "Invalid information";
            }

            throw new CustomException($errorMessage);
        }
    }

    public function createBulkOrder($request)
    {
        if (!env("PATHAO_CLIENT_ID") || !env("PATHAO_CLIENT_SECRET")) {
            throw new CustomException("Pathao credential not configured");
        }

        $orders = Order::where("courier_id", 2)->whereIn("id", $request->order_ids)->get();

        $data = [];

        foreach ($orders as $order) {

            $data[] = [
                "item_type"           => 2,
                "store_id"            => $order->pickup_store_id,
                "merchant_order_id"   => $order->id,
                "recipient_name"      => $order->customer_name,
                "recipient_phone"     => $order->phone_number,
                "recipient_address"   => $order->address_details,
                "amount_to_collect"   => $order->paid_status == StatusEnum::PAID ? 0 : round($order->payable_price),
                "item_quantity"       => $order->details()->sum("quantity"),
                "item_weight"         => $order->item_weight,
                "item_description"    => $order->note,
                "delivery_type"       => $order->delivery_type ?? 48,
                "special_instruction" => "",
            ];
        }

        $url = "$this->endPoint/aladdin/api/v1/orders/bulk";

        $res = Http::withHeaders($this->headers())->post($url, ["orders" => $data]);

        // Update courier current status
        Order::whereIn('id', $request->order_ids)->update(['courier_status_id' => OrderStatusEnum::COURIER_PENDING]);

        return json_decode($res, true);
    }

    public function getStores()
    {
        $cacheKey      = "pathao_stores_data";
        $cacheDuration = now()->addMinutes(60);

        return Cache::remember($cacheKey, $cacheDuration, function () {
            $url = "$this->endPoint/aladdin/api/v1/stores";
            $res = Http::withHeaders($this->headers())->get($url);

            return json_decode($res, true);
        });
    }

    public function callback($request)
    {
        $requestEvent  = $request->event;

        $order = Order::where("consignment_id", $request->consignment_id)
        ->orWhere("id", $request->merchant_order_id)
        ->first();

        if (!$order) {
            return false;
        }

        if ($requestEvent == "order.in-transit") {
            $order->courier_status_id = OrderStatusEnum::COURIER_PENDING;
        } elseif ($requestEvent == "order.delivered") {
            $order->current_status_id = OrderStatusEnum::DELIVERED;
            $order->courier_status_id = OrderStatusEnum::DELIVERED;
        } elseif ($requestEvent == "order.returned") {
            $order->current_status_id = OrderStatusEnum::PENDING_RETURNED;
            $order->courier_status_id = OrderStatusEnum::PENDING_RETURNED;
        } elseif ($requestEvent == "order.partial-delivery") {
            $order->current_status_id = OrderStatusEnum::PARTIAL_RETURNED;
            $order->courier_status_id = OrderStatusEnum::PARTIAL_RETURNED;
        }

        $existingResponses = $order->callback_response ?? [];
        if (!is_array($existingResponses)) {
            $existingResponses = json_decode($existingResponses, true) ?? [];
        }

        $existingResponses[] = [
            "consignment_id"    => $request->consignment_id,
            "merchant_order_id" => $request->merchant_order_id,
            "updated_at"        => $request->updated_at,
            "timestamp"         => $request->timestamp,
            "store_id"          => $request->store_id,
            "event"             => $requestEvent,
            "collected_amount"  => $request->collected_amount,
            "reason"            => $request->reason
        ];

        $order->callback_response = $existingResponses;
        $order->save();

        return true;
    }
}
