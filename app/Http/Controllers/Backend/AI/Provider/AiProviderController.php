<?php

namespace App\Http\Controllers\Backend\AI\Provider;

use App\Http\Controllers\BaseController;
use App\Http\Requests\Backend\AI\Provider\AiProviderRequest;
use App\Http\Resources\Backend\AI\AiProviderCollection;
use App\Http\Resources\Backend\AI\AiProviderResource;
use App\Services\AI\Provider\AiProviderService;
use Illuminate\Http\Request;

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

        return $this->sendResponse($results, "AI Provider List");
    }
}
