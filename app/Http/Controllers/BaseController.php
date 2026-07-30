<?php

namespace App\Http\Controllers;

use Illuminate\Http\Exceptions\HttpResponseException;

class BaseController extends Controller
{
    public function sendResponse($data = null, string $message = 'Success', int $status = 200)
    {
        return response()->json([
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $status);
    }

    public function sendError(string $message = 'Something went wrong.',int $status = 400,array $errors = [])
    {
        $response = [
            'success' => false,
            'message' => $message,
        ];

        if (! empty($errors)) {
            $response['errors'] = $errors;
        }

        return response()->json($response, $status);
    }

    protected function authorizePermission($user, string $permission, string $message = 'You do not have permission to perform this action.'): void
    {
        if (! $user || ! $user->hasPermission($permission)) {
            throw new HttpResponseException(
                response()->json([
                    'success' => false,
                    'message' => $message,
                ], 403)
            );
        }
    }
}
