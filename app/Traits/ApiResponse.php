<?php

namespace App\Traits;

trait ApiResponse
{
    public function success($data = [], $message = 'Success'){
        return response()->json([
            'status' => true,
            'message' => $message,
            'data' => $data
        ]);
    }

    public function error($message = 'Error', $code = 400)
    {
        return response()->json([
            'status' => false,
            'message' => $message
        ], $code);
    }
}