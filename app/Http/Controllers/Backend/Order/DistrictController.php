<?php

namespace App\Http\Controllers\Backend\Order;

use Illuminate\Http\Request;
use App\Services\Order\DistrictService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\Order\DistrictRequest;
use App\Http\Resources\Backend\Order\DistrictResource;
use App\Http\Resources\Backend\Order\DistrictCollection;

class DistrictController extends BaseController
{
    public function __construct(protected DistrictService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'district_read', 'You have no permission for read this');

        $districts = $this->service->index($request);

        $districts = new DistrictCollection($districts);

        return $this->sendResponse($districts, "District List.");
    }

    public function list()
    {
        $district = $this->service->list();

        return $this->sendResponse($district, "District List");
    }

    public function store(DistrictRequest $request)
    {
        $this->authorizePermission($request->user(), 'district_create', 'You have no permission for create this');

        $district = $this->service->store($request);

        $district = new DistrictResource($district);

        return $this->sendResponse($district, "District Created Successfully.");
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'district_read', 'You have no permission for show this');

        $district = $this->service->show($id);

        $district = new DistrictResource($district);

        return $this->sendResponse($district, "District Show.");
    }

    public function update(DistrictRequest $request, $id)
    {
        $this->authorizePermission($request->user(), 'district_update', 'You have no permission for update this');

        $district = $this->service->update($request, $id);

        $district = new DistrictResource($district);

        return $this->sendResponse($district, "District Updated Successfully.");
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'district_delete', 'You have no permission for delete this');

        $this->service->destroy($id);

        return $this->sendResponse([], "District Deleted Successfully.");
    }
}
