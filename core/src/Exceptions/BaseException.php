<?php

namespace Core\Exceptions;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

abstract class BaseException extends HttpException
{
    private int $statusCode = Response::HTTP_BAD_REQUEST;

    public function __construct(string $message = "", int $exceptionCode = 0, ?int $statusCode = null)
    {
        parent::__construct($statusCode ?: $this->statusCode, $message, null, [], $exceptionCode);
    }
}
