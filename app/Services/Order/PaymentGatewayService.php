<?php

namespace App\Services\Order;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Exceptions\CustomException;
use App\Models\Order\PaymentGateway;
use App\Helpers\File\FileUploadHelper;

class PaymentGatewayService
{
    public function __construct(protected PaymentGateway $model){}

    public function index($request)
    {
        $paginateSize = $request->input('paginate_size', 25);

        $results = $this->model
        ->with([
            'createdBy:id,username',
            'updatedBy:id,username',
        ])
        ->orderBy('position', 'ASC')
        ->paginate($paginateSize);

        return $results;
    }

    public function trashList($request)
    {
        $paginateSize = $request->input('paginate_size', 25);

        $results = $this->model::onlyTrashed()
        ->with('deletedBy:id,username')
        ->orderBy('position', 'ASC')
        ->paginate($paginateSize);

        return $results;
    }

    public function list()
    {
        $results = $this->model::select('id', 'name', 'slug', 'phone_number')->where('status', 'active')->orderBy('position', 'ASC')->get();

        return $results;
    }

    public function store($request)
    {
        return DB::transaction(function () use ($request) {
            $paymentGateway = new $this->model();

            $paymentGateway->name           = Str::title($request->name);
            $paymentGateway->account_number = $request->account_number ?? NULL;
            $paymentGateway->position       = $request->position ?? 0;
            $paymentGateway->status         = $request->status;

            if($request->hasFile('image') && $request->file('image')->isValid()){
                $paymentGateway->img_path = FileUploadHelper::upload($request->file('image'), 'payment_gateways');
            }

            $paymentGateway->save();

            return $paymentGateway;
        });
    }

    public function show($id)
    {
        $paymentGateway = $this->model::find($id);

        if(!$paymentGateway){
            throw new CustomException("Payment Gateway not found");
        }

        return $paymentGateway;
    }

    public function update($request, $id)
    {
        return DB::transaction(function () use ($request, $id) {
            $paymentGateway = $this->model::find($id);

            if(!$paymentGateway){
                throw new CustomException("Payment Gateway not found");
            }

            $paymentGateway->name           = Str::title($request->name);
            $paymentGateway->account_number = $request->account_number ?? NULL;
            $paymentGateway->position       = $request->position ?? 0;
            $paymentGateway->status         = $request->status;

            if($request->hasFile('image') && $request->file('image')->isValid()){
                $paymentGateway->img_path = FileUploadHelper::upload($request->file('image'), 'payment_gateways');
            }

            $paymentGateway->save();

            return $paymentGateway;
        });
    }

    public function destroy($id)
    {
        $paymentGateway = $this->model::find($id);

        if(!$paymentGateway){
            throw new CustomException("Payment Gateway not found");
        }

        $paymentGateway->delete();

        return true;
    }

    public function restore($id)
    {
        $paymentGateway = $this->model::find($id);

        if(!$paymentGateway){
            throw new CustomException("Payment Gateway not found");
        }

        $paymentGateway->restore();

        return $paymentGateway;
    }

    public function permanentDelete($id)
    {
        $paymentGateway = $this->model::find($id);

        if(!$paymentGateway){
            throw new CustomException("Payment Gateway not found");
        }

        $paymentGateway->forceDelete();

        return true;
    }
}
