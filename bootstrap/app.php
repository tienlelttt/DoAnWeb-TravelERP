<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->redirectGuestsTo(function (Request $request) {
            if ($request->is('api/*')) {
                return null; // Không redirect, quăng AuthenticationException
            }
            return route('login');
        });

        // Đăng ký middleware alias cho toàn ứng dụng
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'audit_log' => \App\Http\Middleware\AuditLogMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->shouldRenderJsonWhen(
            fn (Request $request) => $request->is('api/*')
        );

        $exceptions->render(function (\App\Exceptions\AppException $e, Request $request) {
            return response()->json([
                'status' => $e->getHttpStatus(),
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
                'error' => $e->getErrorCode()
            ], $e->getHttpStatus(), [], JSON_UNESCAPED_UNICODE);
        });

        $exceptions->render(function (\Illuminate\Validation\ValidationException $e, Request $request) {
            $message = collect($e->errors())->map(function($messages, $field) {
                return $field . ': ' . implode(', ', $messages);
            })->implode(', ');

            return response()->json([
                'status' => 400,
                'success' => false,
                'message' => $message,
                'data' => null,
                'error' => 'VALIDATION_ERROR'
            ], 400, [], JSON_UNESCAPED_UNICODE);
        });

        $exceptions->render(function (\Illuminate\Auth\AuthenticationException $e, Request $request) {
            return response()->json([
                'status' => 401,
                'success' => false,
                'message' => 'Sai tên đăng nhập hoặc mật khẩu hoặc Token hết hạn',
                'data' => null,
                'error' => 'AUTHENTICATION_FAILED'
            ], 401, [], JSON_UNESCAPED_UNICODE);
        });

        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\NotFoundHttpException $e, Request $request) {
            return response()->json([
                'status' => 404,
                'success' => false,
                'message' => 'Không tìm thấy đường dẫn: ' . $request->path(),
                'data' => null,
                'error' => 'NOT_FOUND'
            ], 404, [], JSON_UNESCAPED_UNICODE);
        });
        
        $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e, Request $request) {
            return response()->json([
                'status' => 403,
                'success' => false,
                'message' => 'Bạn không có quyền truy cập tài nguyên này',
                'data' => null,
                'error' => 'FORBIDDEN'
            ], 403, [], JSON_UNESCAPED_UNICODE);
        });
    })->create();
