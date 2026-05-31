<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware bảo vệ cuối cùng chuyển đổi đệ quy các key của JSON Response
 * từ snake_case sang camelCase trước khi gửi cho React Frontend.
 */
class CamelCaseJsonResponse
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if ($response instanceof JsonResponse) {
            $data = $response->getData(true);
            if (is_array($data)) {
                $response->setData($this->convertKeysToCamelCase($data));
            }
        }

        return $response;
    }

    private function convertKeysToCamelCase(array $array): array
    {
        $result = [];
        foreach ($array as $key => $value) {
            // Chuyển key sang camelCase
            $camelKey = Str::camel($key);
            
            // Đệ quy nếu giá trị là mảng
            if (is_array($value)) {
                $result[$camelKey] = $this->convertKeysToCamelCase($value);
            } else {
                $result[$camelKey] = $value;
            }
        }
        return $result;
    }
}
