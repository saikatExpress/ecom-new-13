<?php

namespace App\Http\Controllers\Backend\AI;

use Throwable;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\BaseController;
use App\Services\AI\Blog\BlogAiService;
use Laravel\Ai\Exceptions\RateLimitedException;
use App\Http\Requests\Backend\AI\Blog\BlogAiGenerateRequest;

class BlogAiController extends BaseController
{
    public function __construct(protected BlogAiService $service) {}

    public function generate(BlogAiGenerateRequest $request): JsonResponse {
        try {

            $data = $this->service->generate($request->validated('prompt'));

            if (! $data['is_valid']) {
                return $this->sendError($data['message'],422);
            }

            return $this->sendResponse($data,$data['message']);

        } catch (RateLimitedException $e) {

            report($e);

            return $this->sendError('AI provider rate limit reached. Please try again later.',429);

        } catch (Throwable $e) {

            report($e);

            return $this->sendError('Unable to generate blog content.',500);
        }
    }
}
