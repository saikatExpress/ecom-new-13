<?php

namespace App\Services\Order;

use App\Exceptions\CustomException;
use App\Models\Order\OrderSource;
use Illuminate\Support\Str;

class OrderSourceService
{
    public function __construct(protected OrderSource $model){}

    public function index($request)
    {
        $searchKey = $request->input('search_key');

        $results = $this->model
        ->when($searchKey, function($query, $searchKey){
            $query->where('name', 'like', "%{$searchKey}%");
        })
        ->get();

        return $results;
    }

    public function list()
    {
        $results = $this->model::where('status', 'active')->get();

        return $results;
    }

    public function store($request)
    {
        $orderSource = new $this->model();

        $orderSource->name       = Str::title($request->name);
        $orderSource->slug       = Str::slug($request->name);
        $orderSource->color_code = $request->color_code ?? NULL;
        $orderSource->status     = $request->status;

        $orderSource->save();

        return $orderSource;
    }

    public function show($id)
    {
        $orderSource = $this->model::find($id);

        if(!$orderSource){
            throw new CustomException("Order Source Not Found");
        }

        return $orderSource;
    }

    public function update($request, $id)
    {
        $orderSource = $this->model::find($id);

        if(!$orderSource){
            throw new CustomException("Order Source Not Found");
        }

        $orderSource->name       = Str::title($request->name);
        $orderSource->slug       = Str::slug($request->name);
        $orderSource->color_code = $request->color_code ?? NULL;
        $orderSource->status     = $request->status;

        $orderSource->save();

        return $orderSource;
    }

    public function destroy($id)
    {
        $orderSource = $this->model::find($id);

        if(!$orderSource){
            throw new CustomException("Order Source Not Found");
        }

        $orderSource->delete();

        return true;
    }
}
