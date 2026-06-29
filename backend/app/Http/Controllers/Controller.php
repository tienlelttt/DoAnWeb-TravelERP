<?php

namespace App\Http\Controllers;

// Module quản lý dữ liệu.
abstract class Controller
{

    protected function normalizePerPage($value, int $default = 15, int $max = 100): int
    {
        $perPage = (int) ($value ?: $default);

        return max(1, min($perPage, $max));
    }

    protected function successResponse($data = null, string $message = 'Thành công', int $status = 200)
    {
        return response()->json([
            'status'  => $status,
            'success' => true,
            'message' => $message,
            'data'    => $data,
            'errors'  => null,
            'meta'    => new \stdClass(),
        ], $status, [], JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION);
    }

    protected function paginatedResponse($paginator, string $message = 'Thành công', int $status = 200)
    {
        return response()->json([
            'status'  => $status,
            'success' => true,
            'message' => $message,
            'data'    => $paginator->items(),
            'errors'  => null,
            'meta'    => [
                'pagination' => [
                    'current_page' => $paginator->currentPage(),
                    'per_page' => $paginator->perPage(),
                    'total' => $paginator->total(),
                    'last_page' => $paginator->lastPage(),
                    'from' => $paginator->firstItem(),
                    'to' => $paginator->lastItem(),
                ],
            ],
        ], $status, [], JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION);
    }

    protected function noContent(string $message = 'Thành công')
    {
        return $this->successResponse(null, $message);
    }

    protected function errorResponse(string $message, int $status = 400, string $error = 'ERROR')
    {
        return response()->json([
            'status'  => $status,
            'success' => false,
            'message' => $message,
            'data'    => null,
            'error'   => $error,
            'errors'  => ['code' => $error],
            'meta'    => new \stdClass(),
        ], $status, [], JSON_UNESCAPED_UNICODE);
    }
}
