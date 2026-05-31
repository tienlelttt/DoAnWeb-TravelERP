<?php

namespace App\Exceptions;

use Exception;

class AppException extends Exception
{
    protected int $httpStatus;
    protected string $errorCode;

    public function __construct(int $httpStatus, string $errorCode, string $message)
    {
        parent::__construct($message);
        $this->httpStatus = $httpStatus;
        $this->errorCode = $errorCode;
    }

    public function getHttpStatus(): int
    {
        return $this->httpStatus;
    }

    public function getErrorCode(): string
    {
        return $this->errorCode;
    }

    public static function badRequest(string $message, string $errorCode = "BAD_REQUEST"): self
    {
        return new self(400, $errorCode, $message);
    }

    public static function unauthorized(string $message, string $errorCode = "UNAUTHORIZED"): self
    {
        return new self(401, $errorCode, $message);
    }

    public static function notFound(string $message, string $errorCode = "NOT_FOUND"): self
    {
        return new self(404, $errorCode, $message);
    }

    public static function forbidden(string $message, string $errorCode = "FORBIDDEN"): self
    {
        return new self(403, $errorCode, $message);
    }
}
