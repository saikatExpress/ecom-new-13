<?php

namespace App\Http\Controllers\Backend\AI\Product;

use Throwable;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController;
use App\Services\AI\Product\ProductAiService;
use Laravel\Ai\Exceptions\RateLimitedException;
use App\Http\Requests\Backend\AI\Product\ProductAiGenerateRequest;

class ProductAiController extends BaseController
{
    public function __construct(protected ProductAiService $service) {}

    public function generate(ProductAiGenerateRequest $request): JsonResponse {
        try {
            $data = $this->service->generate($request->validated());

            return $this->sendResponse($data,'Product content generated successfully.');
        } catch (RateLimitedException $e) {
            report($e);

            return $this->sendError('AI provider rate limit reached. Please try again later.',429);
        } catch (Throwable $e) {
            report($e);

            return $this->sendError('Unable to generate product content.',500);
        }
    }
}
