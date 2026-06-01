<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Trả về định dạng JSON chuẩn của hệ thống.
     */
    protected function formatResponse(int $status, bool $success, string $message, $data = null, $error = null, $errors = null, array $meta = []): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'success' => $success,
            'message' => $message,
            'data' => $data,
            'error' => $error,
            'errors' => $errors,
            'meta' => $meta,
        ], $status, [], JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION);
    }

    public function ok(string $message = "Thành công", $data = null): JsonResponse
    {
        return $this->formatResponse(200, true, $message, $data);
    }

    public function created($data = null, string $message = "Tạo mới thành công"): JsonResponse
    {
        return $this->formatResponse(201, true, $message, $data);
    }

    public function noContent(string $message = "Thành công"): JsonResponse
    {
        // Một số màn hình frontend vẫn kỳ vọng response 200 có body cho thao tác không trả dữ liệu.
        return $this->formatResponse(200, true, $message);
    }

    public function badRequest(string $errorCode, string $message): JsonResponse
    {
        return $this->formatResponse(400, false, $message, null, $errorCode);
    }

    public function unauthorized(string $errorCode, string $message): JsonResponse
    {
        return $this->formatResponse(401, false, $message, null, $errorCode);
    }

    public function forbidden(string $message): JsonResponse
    {
        return $this->formatResponse(403, false, $message, null, "FORBIDDEN");
    }

    public function notFound(string $message): JsonResponse
    {
        return $this->formatResponse(404, false, $message, null, "NOT_FOUND");
    }

    public function internalError(string $message): JsonResponse
    {
        return $this->formatResponse(500, false, $message, null, "INTERNAL_SERVER_ERROR");
    }
}
