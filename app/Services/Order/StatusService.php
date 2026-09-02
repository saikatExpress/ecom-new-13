<?php

namespace App\Services\Order;

use Illuminate\Support\Str;
use App\Models\Order\Status;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;

class StatusService
{
    public function __construct(protected Status $model){}

    public function index($request)
    {
        $paginateSize = $request->input('paginate_size', 25);

        $statuses = $this->model
        ->with([
            'createdBy:id,username',
            'updatedBy:id,username',
        ])
        ->orderBy('position', 'asc')
        ->paginate($paginateSize);

        return $statuses;
    }

    public function list()
    {
        $statuses = $this->model::select('id', 'name')->where('status', 'active')->orderBy('position', 'asc')->get();

        return $statuses;
    }

    public function trashList($request)
    {
        $paginateSize = $request->input('paginate_size', 25);

        $statuses = $this->model::onlyTrashed()
        ->with([
            'deletedBy:id,username'
        ])
        ->orderBy('position', 'asc')
        ->paginate($paginateSize);

        return $statuses;
    }

    public function store($request)
    {
        return DB::transaction(function() use ($request) {
            $status = new $this->model();

            $status->name       = Str::title($request->name);
            $status->bg_color   = $request->bg_color;
            $status->text_color = $request->text_color;
            $status->icon       = $request->icon;
            $status->position   = $request->position;
            $status->status     = $request->status;
            $status->save();

            return $status;
        });
    }

    public function show($id)
    {
        return DB::transaction(function () use ($id) {
            $status = $this->model::find($id);

            if(!$status){
                throw new CustomException('Status not found');
            }

            return $status;
        });
    }

    public function reorder($request)
    {
        return DB::transaction(function () use ($request) {

            foreach ($request->status_ids as $index => $statusId) {

                $this->model::where('id', $statusId)->update(['position' => $index + 1]);
            }

            return true;
        });
    }

    public function update($request, $id)
    {
        return DB::transaction(function() use ($request, $id) {
            $status = $this->model::find($id);

            if(!$status){
                throw new CustomException('Status not found');
            }

            $status->name       = Str::title($request->name);
            $status->bg_color   = $request->bg_color;
            $status->text_color = $request->text_color;
            $status->icon       = $request->icon;
            $status->position   = $request->position;
            $status->status     = $request->status;
            $status->save();

            return $status;
        });
    }

    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {
            $status = $this->model::find($id);

            if(!$status){
                throw new CustomException('Status not found');
            }

            $status->delete();

            return true;
        });
    }

    public function restore($id)
    {
        return DB::transaction(function () use ($id) {
            $status = $this->model::onlyTrashed()->find($id);

            if(!$status){
                throw new CustomException('Status not found');
            }

            $status->restore();

            return $status;
        });
    }

    public function permanentDelete($id)
    {
        return DB::transaction(function () use ($id) {
            $status = $this->model::onlyTrashed()->find($id);

            if(!$status){
                throw new CustomException('Status not found');
            }

            $status->forceDelete();

            return true;
        });
    }
}
