<?php

namespace App\Http\Controllers\Backend\CMS;

use App\Http\Resources\Backend\CMS\SectionCollection;
use Illuminate\Http\Request;
use App\Services\CMS\SectionService;
use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\CMS\SectionRequest;
use App\Http\Resources\Backend\CMS\SectionResource;

class SectionController extends BaseController
{
    public function __construct(protected SectionService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'section_read', 'You have no permission for read this');

        $sections = $this->service->index($request);

        $sections = new SectionCollection($sections);

        return $this->sendResponse($sections, "Section List");
    }

    public function list()
    {
        $sections = $this->service->list();

        return $this->sendResponse($sections, "Section List");
    }

    public function trashList(Request $request)
    {
        $this->authorizePermission($request->user(), 'section_read', 'You have no permission for read this');

        $sections = $this->service->trashList($request);

        $sections = new SectionCollection($sections);

        return $this->sendResponse($sections, "Section Trash List");
    }

    public function store(SectionRequest $request)
    {
        $this->authorizePermission($request->user(), 'section_create', 'You have no permission for create this');

        $section = $this->service->store($request);

        $section = new SectionResource($section);

        return $this->sendResponse($section, "Section Create Successfully");
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'section_read', 'You have no permission for show this');

        $section = $this->service->show($id);

        $section = new SectionResource($section);

        return $this->sendResponse($section, "Section Show");
    }

    public function update(SectionRequest $request, $id)
    {
        $this->authorizePermission($request->user(), 'section_update', 'You have no permission for update this');

        $section = $this->service->update($request, $id);

        $section = new SectionResource($section);

        return $this->sendResponse($section, "Section Update Successfully");
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'section_delete', 'You have no permission for delete this');

        $this->service->destroy($id);

        return $this->sendResponse([], "Section Delete Successfully");
    }

    public function restore(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'section_read', 'You have no permission for show this');

        $section = $this->service->restore($id);

        $section = new SectionResource($section);

        return $this->sendResponse($section, "Section Restore Successfully");
    }

    public function permanentDelete(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'section_delete', 'You have no permission for delete this');

        $this->service->permanentDelete($id);

        return $this->sendResponse([], "Section Permanent Delete Successfully");
    }
}
