<?php

namespace App\Http\Controllers;

abstract class Controller
{
    protected function successResponse($data = null, string $message = 'Thành công', int $status = 200)
    {
        return response()->json([
            'status'  => $status,
            'success' => true,
            'message' => $message,
            'data'    => $data,
        ], $status, [], JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION);
    }

    protected function errorResponse(string $message, int $status = 400, string $error = 'ERROR')
    {
        return response()->json([
            'status'  => $status,
            'success' => false,
            'message' => $message,
            'data'    => null,
            'error'   => $error,
        ], $status, [], JSON_UNESCAPED_UNICODE);
    }
}
