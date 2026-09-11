<?php

namespace App\Http\Controllers\Backend\Order;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Order\OrderNoteService;
use App\Http\Requests\Backend\Order\OrderNoteRequest;

class OrderNoteController extends BaseController
{
    public function __construct(protected OrderNoteService $service){}

    public function index(Request $request)
    {
        $notes = $this->service->index($request);

        return $this->sendResponse($notes, "Order Notes");
    }

    public function store(OrderNoteRequest $request)
    {
        $note = $this->service->store($request);

        return $this->sendResponse($note, "Note Created Successfully");
    }

    public function update(OrderNoteRequest $request, $id)
    {
        $note = $this->service->update($request, $id);

        return $this->sendResponse($note, "Note Updated Successfully");
    }

    public function destroy($id)
    {
        $this->service->destroy($id);

        return $this->sendResponse([], "Note Deleted Successfully");
    }
}
