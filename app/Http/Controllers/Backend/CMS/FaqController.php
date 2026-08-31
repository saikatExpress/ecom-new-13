<?php

namespace App\Http\Controllers\Backend\CMS;

use Illuminate\Http\Request;
use App\Services\CMS\FaqService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\CMS\FaqRequest;

class FaqController extends BaseController
{
    public function __construct(protected FaqService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'page_read', 'You have no permission for read this');

        $faqs = $this->service->index();

        return $this->sendResponse($faqs, 'Faqs retrive successfully');
    }

    public function store(FaqRequest $request)
    {
        $this->authorizePermission($request->user(), 'page_create', 'You do not have permission for create this');

        $faq = $this->service->store($request);

        return $this->sendResponse($faq, "Faq Created Successfully");
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'page_read', 'You do not have permission for show this');

        $faq = $this->service->show($id);

        return $this->sendResponse($faq, "Faq Show");
    }

    public function update(FaqRequest $request, $id)
    {
        $this->authorizePermission($request->user(), 'page_update', 'You do not have permission for update this');

        $faq = $this->service->update($request, $id);

        return $this->sendResponse($faq, "Faq Updated Successfully");
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'page_delete', 'You do not have permission for delete this');

        $this->service->destroy($id);

        return $this->sendResponse([], "Faq Delete Successfully");
    }
}
