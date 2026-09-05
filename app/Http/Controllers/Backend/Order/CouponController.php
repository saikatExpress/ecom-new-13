<?php

namespace App\Http\Controllers\Backend\Order;

use App\Http\Resources\Backend\Order\CouponResource;
use Illuminate\Http\Request;
use App\Services\Order\CouponService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\Order\CouponRequest;
use App\Http\Resources\Backend\Order\CouponCollection;

class CouponController extends BaseController
{
    public function __construct(protected CouponService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'coupon_read', 'You have no permission for read this');

        $coupons = $this->service->index($request);

        $coupons = new CouponCollection($coupons);

        return $this->sendResponse($coupons, "All Coupons");
    }

    public function trashList(Request $request)
    {
        $this->authorizePermission($request->user(), 'coupon_read', 'You have no permission for read this');

        $coupons = $this->service->trashList($request);

        $coupons = new CouponCollection($coupons);

        return $this->sendResponse($coupons, "Coupons Trash List");
    }

    public function store(CouponRequest $request)
    {
        $this->authorizePermission($request->user(), 'coupon_create', 'You have no permission for create this');

        $coupon = $this->service->store($request);

        $coupon = new CouponResource($coupon);

        return $this->sendResponse($coupon, "Coupon Created Successfully");
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'coupon_read', 'You have no permission for show this');

        $coupon = $this->service->show($id);

        $coupon = new CouponResource($coupon);

        return $this->sendResponse($coupon, "Coupon Show");
    }

    public function update(CouponRequest $request, $id)
    {
        $this->authorizePermission($request->user(), 'coupon_update', 'You have no permission for update this');

        $coupon = $this->service->update($request, $id);

        $coupon = new CouponResource($coupon);

        return $this->sendResponse($coupon, "Coupon Updated Successfully");
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'coupon_delete', 'You have no permission for delete this');

        $this->service->destroy($id);

        return $this->sendResponse([], "Coupon Delete Successfully");
    }

    public function restore(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'coupon_read', 'You have no permission for show this');

        $coupon = $this->service->restore($id);

        $coupon = new CouponResource($coupon);

        return $this->sendResponse($coupon, "Coupon Restore Successfully");
    }

    public function permanentDelete(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'coupon_delete', 'You have no permission for delete this');

        $this->service->permanentDelete($id);

        return $this->sendResponse([], "Coupon Delete Permanently");
    }
}
