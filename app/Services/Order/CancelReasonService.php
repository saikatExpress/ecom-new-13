<?php

namespace App\Services\Order;

use Illuminate\Support\Str;
use App\Models\Order\CancelReason;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;

class CancelReasonService
{
    public function __construct(protected CancelReason $model){}

    public function index($request)
    {
        $searchKey = $request->input('search_key');

        $cancelReason = $this->model
        ->when($searchKey, function ($query, $searchKey) {
            $query->where('name', 'like', "%{$searchKey}%");
        })
        ->get();

        return $cancelReason;
    }

    public function list()
    {
        return $this->model::select('id', 'name', 'slug')->where('status', 'active')->orderBy('name')->get();
    }

    public function store($request)
    {
        return DB::transaction(function () use ($request) {

            $cancelReason = new $this->model();

            $cancelReason->name   = Str::title($request->name);
            $cancelReason->slug   = Str::slug($request->name, '-');
            $cancelReason->status = $request->status;

            $cancelReason->save();

            return $cancelReason;
        });
    }

    public function show($id)
    {
        $cancelReason = $this->model::find($id);

        if (!$cancelReason) {
            throw new CustomException('Cancel reason not found');
        }

        return $cancelReason;
    }

    public function update($request, $id)
    {
        return DB::transaction(function () use ($request, $id) {

            $cancelReason = $this->model::find($id);

            if (!$cancelReason) {
                throw new CustomException('Cancel reason not found');
            }

            $cancelReason->name   = Str::title($request->name);
            $cancelReason->slug   = Str::slug($request->name, '-');
            $cancelReason->status = $request->status;

            $cancelReason->save();

            return $cancelReason->fresh();
        });
    }

    public function destroy($id)
    {
        $cancelReason = $this->model::find($id);

        if (!$cancelReason) {
            throw new CustomException('Cancel reason not found');
        }

        $cancelReason->delete();

        return true;
    }
}
