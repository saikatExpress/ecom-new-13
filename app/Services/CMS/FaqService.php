<?php

namespace App\Services\CMS;

use App\Exceptions\CustomException;
use App\Models\CMS\Faq;

class FaqService
{
    public function __construct(protected Faq $model){}

    public function index()
    {
        $faqs = $this->model::all();

        return $faqs;
    }

    public function store($request)
    {
        $faq = new $this->model();

        $faq->question = $request->question;
        $faq->answer   = $request->answer;
        $faq->position = $request->position;
        $faq->status   = $request->status;
        $faq->save();

        return $faq;
    }

    public function show($id)
    {
        $faq = $this->model::find($id);

        if(!$faq){
            throw new CustomException("Faq Not Found");
        }

        return $faq;
    }

    public function update($request, $id)
    {
        $faq = $this->model::find($id);

        if(!$faq){
            throw new CustomException("Faq not found");
        }

        $faq->question = $request->question;
        $faq->answer   = $request->answer;
        $faq->position = $request->position;
        $faq->status   = $request->status;
        $faq->save();

        return $faq;
    }

    public function destroy($id)
    {
        $faq = $this->model::find($id);

        $faq->delete();

        return true;
    }
}
