<?php

namespace App\Traits;

use Illuminate\Http\JsonResponse;

trait ApiResponse
{
    /**
     * Trả về định dạng JSON chuẩn của hệ thống (Khớp hoàn toàn với Spring Boot).
     */
    protected function formatResponse(int $status, bool $success, string $message, $data = null, $error = null): JsonResponse
    {
        return response()->json([
            'status' => $status,
            'success' => $success,
            'message' => $message,
            'data' => $data,
            'error' => $error
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
        // Spring Boot ResponseEntity.noContent() thường ko có body, nhưng theo AuthController cũ thì nó trả về ApiResponse.noContent(...) status 200
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
