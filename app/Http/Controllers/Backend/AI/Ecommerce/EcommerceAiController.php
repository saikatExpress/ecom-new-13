<?php

namespace App\Http\Controllers\Backend\AI\Ecommerce;

use Throwable;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController;
use Laravel\Ai\Exceptions\RateLimitedException;
use App\Services\AI\Ecommerce\EcommerceAiService;
use App\Http\Requests\Backend\AI\Ecommerce\EcommerceAiRequest;

class EcommerceAiController extends BaseController
{
    public function __construct(protected EcommerceAiService $service) {}

    public function chat(EcommerceAiRequest $request): JsonResponse {
        try {
            $response = $this->service->chat($request->validated('message'));

            return $this->sendResponse(['message' => $response,],'AI response generated successfully.');
        } catch (RateLimitedException $e) {
            report($e);

            return $this->sendError('AI provider rate limit reached. Please try again later.',429);
        } catch (Throwable $e) {
            report($e);

            return $this->sendError('Unable to process AI request.',500);
        }
    }
}
