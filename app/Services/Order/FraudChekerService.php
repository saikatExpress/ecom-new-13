<?php

namespace App\Services\Order;

use Throwable;
use Illuminate\Support\Facades\Http;

class FraudChekerService
{
    public function fraudCheck($request)
    {
        $phoneNumber = $request->input('phone');

        try {
            $response = Http::acceptJson()->contentType('application/json')->withToken(config('services.bd_courier.key'))->timeout(15)
            ->post(
                config('services.bd_courier.url'),
                [
                    'phone' => $phoneNumber,
                ]
            );

            if ($response->failed()) {
                return ['status' => 'error', 'message' => $response->json('message') ?? 'Fraud checker API request failed.'];
            }

            $data = $response->json();

            if (($data['status'] ?? null) === 'error') {
                return ['status' => 'error', 'message' => $data['message'] ?? 'Fraud check failed.'];
            }

            return [
                'status'  => 'success',
                'data'    => $data['data'] ?? [],
                'reports' => $data['reports'] ?? [],
            ];

        } catch (Throwable $e) {

            report($e);

            return [
                'status' => 'error',
                'message' => 'Unable to connect to fraud checker service.',
            ];
        }
    }
}
