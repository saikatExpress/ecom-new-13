<?php

namespace App\Services\Order;

use App\Enums\StatusEnum;
use App\Exceptions\CustomException;
use App\Models\Order\District;
use Illuminate\Support\Str;

class DistrictService
{
    public function __construct(protected District $model){}

    public function index($request)
    {
        $paginateSize = $request->input('paginate_size', 25);
        $searchKey    = $request->input('search_key', null);
        $status       = $request->input('status', null);

        $districts = $this->model
        ->withCount('orders')
        ->when($searchKey, function($query) use ($searchKey){
            $query->where('district_name', 'like', "%{$searchKey}%")
            ->orWhere('division_name', 'like', "%{$searchKey}%");
        })
        ->when($status, function($query, $status) {
            $query->where('status', $status);
        })
        ->orderBy('district_name', 'asc')
        ->paginate($paginateSize);

        return $districts;
    }

    public function list()
    {
        return $this->model::select('id', 'district_name')->where('status', StatusEnum::ACTIVE)->get();
    }

    public function store($request)
    {
        $district = new $this->model();

        $district->division_name = Str::title($request->input('division_name'));
        $district->district_name = Str::title($request->input('district_name'));
        $district->status        = $request->input('status');

        $district->save();

        return $district;
    }

    public function show($id)
    {
        $district = $this->model::find($id);

        return $district;
    }

    public function update($request, $id)
    {
        $district = $this->model::find($id);

        if(!$district){
            throw new CustomException("District not found");
        }

        $district->division_name = Str::title($request->input('division_name'));
        $district->district_name = Str::title($request->input('district_name'));
        $district->status        = $request->input('status');

        $district->save();

        return $district;
    }

    public function destroy($id)
    {
        $district = $this->model::find($id);

        if(!$district){
            throw new CustomException("District not found");
        }

        $district->delete();

        return true;
    }
}
