<?php

namespace App\Http\Controllers\Backend\AI\Provider;

use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\AI\Provider\AiProviderService;
use App\Http\Resources\Backend\AI\AiProviderResource;
use App\Http\Resources\Backend\AI\AiProviderCollection;
use App\Http\Requests\Backend\AI\Provider\AiProviderRequest;

class AiProviderController extends BaseController
{
    public function __construct(protected AiProviderService $service){}

    public function index(Request $request)
    {
        $this->authorizePermission($request->user(), 'ai_read', 'You have no permission for read this');

        $results = $this->service->index($request);

        $results = new AiProviderCollection($results);

        return $this->sendResponse($results, "AI Provider List");
    }

    public function store(AiProviderRequest $request)
    {
        $this->authorizePermission($request->user(), 'ai_create', 'You have no permission for create this');

        $results = $this->service->store($request);

        $results = new AiProviderResource($results);

        return $this->sendResponse($results, "AI Provider Created Successfully");
    }

    public function show(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'ai_read', 'You have no permission for show this');

        $results = $this->service->show($id);

        $results = new AiProviderResource($results);

        return $this->sendResponse($results, "AI Provider Show");
    }

    public function update(AiProviderRequest $request, $id)
    {
        $this->authorizePermission($request->user(), 'ai_update', 'You have no permission for update this');

        $results = $this->service->update($request, $id);

        $results = new AiProviderResource($results);

        return $this->sendResponse($results, "AI Provider Updated Successfully");
    }

    public function destroy(Request $request, $id)
    {
        $this->authorizePermission($request->user(), 'ai_delete', 'You have no permission for delete this');

        $this->service->destroy($id);


        return $this->sendResponse([], "AI Provider Delete Successfully");
    }
}
