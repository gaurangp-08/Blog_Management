<?php

namespace App\Services;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Crypt;

class ResponseService
{
    /**
     * Create a success response.
     *
     * @param mixed $data
     * @param int $status
     * @return JsonResponse
     */
    public function success($data = null, int $status = 200, string $message = 'Success'): JsonResponse
    {
        return response()->json([
            'code'=> $status,
            'success' => true,
            'message' => $message,
            'data' => $data,
        ], $status);
    }

    /**
     * Create an error response.
     *
     * @param string $message
     * @param int $status
     * @param array $errors
     * @return JsonResponse
     */
    public function error(string $message, int $status = 400, array $errors = []): JsonResponse
    {
        return response()->json([
            'success' => false,
            'code'=> $status,
            'message' => $message,
            'errors' => $errors,
        ], $status);
    }
}
