<?php

namespace App\Services\Order;

use App\Models\Order\OrderNote;
use App\Exceptions\CustomException;

class OrderNoteService
{
    public function __construct(protected OrderNote $model){}

    public function index($request)
    {
        $orderId = $request->input('order_id');

        $notes = $this->model
        ->with([
            'createdBy:id,username',
            'updatedBy:id,username',
        ])
        ->where('order_id', $orderId)
        ->get();

        return $notes;
    }

    public function store($request)
    {
        $note = new $this->model();

        $note->order_id = $request->order_id;
        $note->note     = $request->note;
        $note->save();

        return $note;
    }

    public function update($request, $id)
    {
        $note = $this->model::find($id);

        if(!$note){
            throw new CustomException("Note not found");
        }

        $note->order_id = $request->order_id;
        $note->note     = $request->note;
        $note->save();

        return $note;
    }

    public function destroy($id)
    {
        $note = $this->model::find($id);

        if(!$note){
            throw new CustomException("Note not found");
        }

        $note->delete();

        return true;
    }
}
