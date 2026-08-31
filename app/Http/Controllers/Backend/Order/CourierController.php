<?php

namespace App\Http\Controllers\Backend\Order;

use Illuminate\Http\Request;
use App\Services\Order\CourierService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\Order\CourierRequest;
use App\Http\Resources\Backend\Order\CourierResource;
use App\Http\Resources\Backend\Order\CourierCollection;

class CourierController extends BaseController
{
    public function __construct(protected CourierService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'courier_read', 'You have no permission for read this');

        $couriers = $this->service->index($request);

        $couriers = new CourierCollection($couriers);

        return $this->sendResponse($couriers, "Courier List");
    }

    public function trashList(Request $request)
    {
        $this->authorizePermission($request->user(), 'courier_read', 'You have no permission for read this');

        $couriers = $this->service->trashList($request);

        $couriers = new CourierCollection($couriers);

        return $this->sendResponse($couriers, "Courier Trash List");
    }

    public function list()
    {
        $couriers = $this->service->list();

        return $this->sendResponse($couriers, 'Courier List');
    }

    public function store(CourierRequest $request)
    {
        $this->authorizePermission($request->user(), 'courier_create', 'You have no permission for create this');

        $courier = $this->service->store($request);

        $courier = new CourierResource($courier);

        return $this->sendResponse($courier, "Courier Create Successfully");
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'courier_read', 'You have no permission for show this');

        $courier = $this->service->show($id);

        $courier = new CourierResource($courier);

        return $this->sendResponse($courier, "Courier Show");
    }

    public function update(CourierRequest $request, $id)
    {
        $this->authorizePermission($request->user(), 'courier_update', 'You have no permission for update this');

        $courier = $this->service->update($request, $id);

        $courier = new CourierResource($courier);

        return $this->sendResponse($courier, "Courier Update Successfully");
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'courier_delete', 'You have no permission for delete this');

        $this->service->destroy($id);

        return $this->sendResponse([], "Courier Delete Successfully");
    }

    public function restore(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'courier_read', 'You have no permission for show this');

        $courier = $this->service->restore($id);

        $courier = new CourierResource($courier);

        return $this->sendResponse($courier, "Courier Restore Successfully");
    }

    public function permanentDelete(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'courier_delete', 'You have no permission for delete this');

        $this->service->permanentDelete($id);

        return $this->sendResponse([], "Courier Delete Permanently");
    }
}
