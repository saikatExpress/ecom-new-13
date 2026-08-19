<?php

namespace App\Services\Order;

use Illuminate\Support\Str;
use App\Models\Order\CustomerType;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;

class CustomerTypeService
{
    public function __construct(protected CustomerType $model){}

    public function index()
    {
        $results = $this->model::orderBy('order_range')->get();

        return $results;
    }

    public function list()
    {
        $results = $this->model::where('status', 'active')->orderBy('order_range')->get();

        return $results;
    }

    public function store($request)
    {
        return DB::transaction(function () use ($request) {

            $customerType = new $this->model();

            $customerType->name        = Str::title($request->name);
            $customerType->slug        = Str::slug($request->name);
            $customerType->order_range = $request->order_range;
            $customerType->status      = $request->status;

            $customerType->save();

            return $customerType;
        });
    }

    public function show($id)
    {
        $customerType = $this->model::find($id);

        if (!$customerType) {
            throw new CustomException('Customer type not found');
        }

        return $customerType;
    }

    public function update($request, $id)
    {
        return DB::transaction(function () use ($request, $id) {

            $customerType = $this->model::find($id);

            if (!$customerType) {
                throw new CustomException('Customer type not found');
            }

            $customerType->name        = Str::title($request->name);
            $customerType->slug        = Str::slug($request->name);
            $customerType->order_range = $request->order_range;
            $customerType->status      = $request->status;
            $customerType->save();

            return $customerType->fresh();
        });
    }

    public function destroy($id)
    {
        $customerType = $this->model::find($id);

        if (!$customerType) {
            throw new CustomException('Customer type not found');
        }

        $customerType->delete();

        return true;
    }
}
