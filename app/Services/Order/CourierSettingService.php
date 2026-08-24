<?php

namespace App\Services\Order;

use App\Helpers\Courier\EnvHelper;
use App\Exceptions\CustomException;
use App\Helpers\Courier\RedxSettingHelper;
use App\Helpers\Courier\PathaoSettingHelper;
use App\Helpers\Courier\PaperflySettingHelper;
use App\Helpers\Courier\EcourierSettingHelper;
use App\Helpers\Courier\SteadfastSettingHelper;

class CourierSettingService
{
    public function show($slug)
    {
        $courier = config("couriers.{$slug}");

        if (!$courier) {
            throw new CustomException('Courier not found');
        }

        return $courier;
    }

    public function update($request, string $slug)
    {
        $helpers = [
            'pathao'    => PathaoSettingHelper::class,
            'steadfast' => SteadfastSettingHelper::class,
            'redx'      => RedxSettingHelper::class,
            'paperfly'  => PaperflySettingHelper::class,
            'ecourier'  => EcourierSettingHelper::class,
        ];

        if (!isset($helpers[$slug])) {
            throw new CustomException('Courier setting not supported');
        }

        $envData = $helpers[$slug]::update($request);

        EnvHelper::update($envData);

        return true;
    }
}
