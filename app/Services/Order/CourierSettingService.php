<?php

namespace App\Services\Order;

use App\Models\Order\Courier;
use App\Exceptions\CustomException;
use App\Helpers\Courier\EnvHelper;
use Illuminate\Support\Facades\DB;
use App\Helpers\Courier\RedxSettingHelper;
use App\Helpers\Courier\PathaoSettingHelper;
use App\Helpers\Courier\PaperflySettingHelper;
use App\Helpers\Courier\SteadfastSettingHelper;

class CourierSettingService
{
    public function __construct(protected Courier $model){}

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
        ];

        if (!isset($helpers[$slug])) {
            throw new CustomException('Courier setting not supported');
        }

        $envData = $helpers[$slug]::update($request);

        EnvHelper::update($envData);

        return true;
    }

    public function defaultUpdate($request, $id)
    {
        return DB::transaction(function () use ($request, $id) {

            $courier = $this->model->lockForUpdate()->find($id);

            if (!$courier) {
                throw new CustomException('Courier Not Found');
            }

            $courier->is_default = $request->is_default;
            $courier->save();

            if ((int) $request->is_default === 1) {
                $this->model->where('id', '!=', $courier->id)->update(['is_default' => 0]);
            }

            return $courier->fresh();
        });
    }
}
