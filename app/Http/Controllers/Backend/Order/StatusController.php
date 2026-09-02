<?php

namespace App\Http\Controllers\Backend\Order;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\Order\StatusRequest;
use App\Services\Order\StatusService;
use Illuminate\Http\Request;

class StatusController extends BaseController
{
    public function __construct(protected StatusService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'status_read', 'You have no permission for read this');

        $statuses = $this->service->index();

        return $this->sendResponse($statuses, "Status List");
    }

    public function list()
    {
        $statuses = $this->service->list();

        return $this->sendResponse($statuses, "Status List");
    }

    public function trashList(Request $request)
    {
        $this->authorizePermission($request->user(), 'status_read', 'You have no permission for read this');

        $statuses = $this->service->trashList();

        return $this->sendResponse($statuses, "Status Trash List");
    }

    public function store(StatusRequest $request)
    {
        $this->authorizePermission($request->user(), 'status_create', 'You have no permission for create this');

        $status = $this->service->store($request);

        return $this->sendResponse($status, "Status Created Successfully");
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'status_read', 'You have no permission for show this');

        $status = $this->service->show($id);

        return $this->sendResponse($status, "Status show");
    }

    public function update(StatusRequest $request, $id)
    {
        $this->authorizePermission($request->user(), 'status_update', 'You have no permission for update this');

        $status = $this->service->update($request, $id);

        return $this->sendResponse($status, "Status Updated Successfully");
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'status_delete', 'You have no permission for delete this');

        $this->service->destroy($id);

        return $this->sendResponse([], "Status delete successfully");
    }

    public function restore(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'status_read', 'You have no permission for show this');

        $status = $this->service->restore($id);

        return $this->sendResponse($status, "Status restore successfully");
    }

    public function permanentDelete(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'status_delete', 'You have no permission for delete this');

        $this->service->permanentDelete($id);

        return $this->sendResponse([], "Status delete permanently");
    }
}
