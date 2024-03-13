<?php

namespace Support\Traits;

use Illuminate\Http\JsonResponse;

trait HttpResponses
{
    protected function success(
        mixed $data,
        string $message = null,
        int $code = 200
    ): JsonResponse
    {
        return response()->json(
            data: [
                'status'  => 'Request was successful ✅',
                'message' => $message,
                'data' => $data
            ],
            status: $code
        );
    }

    protected function error(
        mixed $data = null,
        string $message = null,
        int $code = null
    ): JsonResponse
    {
        return response()->json(
            data: [
                'status'  => 'Error has occurred 🆘',
                'message' => $message,
                'data' => $data
            ],
            status: $code
        );
    }
}
