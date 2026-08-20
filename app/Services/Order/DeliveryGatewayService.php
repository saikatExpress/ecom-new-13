<?php

namespace App\Services\Order;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;
use App\Models\Order\DeliveryGateway;

class DeliveryGatewayService
{
    public function __construct(protected DeliveryGateway $model){}

    public function index()
    {
        $results = $this->model
        ->orderBy('position', 'ASC')
        ->get();

        return $results;
    }

    public function list()
    {
        $results = $this->model
        ->select('id', 'name', 'slug', 'min_time', 'max_time','time_units','delivery_fee')
        ->where('status', 'active')
        ->orderBy('position', 'ASC')
        ->get();

        return $results;
    }

    public function store($request)
    {
        return DB::transaction(function () use ($request) {
            $deliveryGateway = new $this->model();

            $deliveryGateway->name         = Str::title($request->name);
            $deliveryGateway->slug         = Str::slug($request->name, '-');
            $deliveryGateway->min_time     = $request->min_time;
            $deliveryGateway->max_time     = $request->max_time;
            $deliveryGateway->time_unit    = $request->time_unit;
            $deliveryGateway->delivery_fee = $request->delivery_fee;
            $deliveryGateway->position     = $request->position;
            $deliveryGateway->status       = $request->status;
            $deliveryGateway->save();
        });
    }

    public function show($id)
    {
        $deliveryGateway = $this->model::find($id);

        if(!$deliveryGateway){
            throw new CustomException("Delivery Gateway not found");
        }

        return $deliveryGateway;
    }

    public function update($request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $deliveryGateway = $this->model::find($id);

            if(!$deliveryGateway){
                throw new CustomException("Delivery Gateway not found");
            }

            $deliveryGateway->name         = Str::title($request->name);
            $deliveryGateway->slug         = Str::slug($request->name, '-');
            $deliveryGateway->min_time     = $request->min_time;
            $deliveryGateway->max_time     = $request->max_time;
            $deliveryGateway->time_unit    = $request->time_unit;
            $deliveryGateway->delivery_fee = $request->delivery_fee;
            $deliveryGateway->position     = $request->position;
            $deliveryGateway->status       = $request->status;
            $deliveryGateway->save();
        });
    }

    public function destroy($id)
    {
        $deliveryGateway = $this->model::find($id);

        if(!$deliveryGateway){
            throw new CustomException("Delivery Gateway not found");
        }

        $deliveryGateway->delete();

        return true;
    }
}
