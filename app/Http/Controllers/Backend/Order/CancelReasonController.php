<?php

namespace App\Http\Controllers\Backend\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Order\CancelReasonService;
use App\Http\Requests\Backend\Order\CancelReasonRequest;

class CancelReasonController extends BaseController
{
    public function __construct(protected CancelReasonService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'cancel_reason_read', 'You have no permission for read this');

        $results = $this->service->index($request);

        return $this->sendResponse($results, 'Cancel Reason List');
    }

    public function list()
    {
        $results = $this->service->list();

        return $this->sendResponse($results, 'Cancel Reason List');
    }

    public function store(CancelReasonRequest $request)
    {
        $this->authorizePermission($request->user(),'cancel_reason_create','You have no permission for create this');

        $result = $this->service->store($request);

        return $this->sendResponse($result,'Cancel Reason created successfully');
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(),'cancel_reason_read','You have no permission for show this');

        $result = $this->service->show($id);

        return $this->sendResponse($result,'Cancel Reason show');
    }

    public function update(CancelReasonRequest $request, $id)
    {
        $this->authorizePermission($request->user(),'cancel_reason_update','You have no permission for update this');

        $result = $this->service->update($request, $id);

        return $this->sendResponse($result,'Cancel Reason updated successfully' );
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(),'cancel_reason_delete','You have no permission for delete this');

        $this->service->destroy($id);

        return $this->sendResponse([],'Cancel Reason deleted successfully');
    }
}
