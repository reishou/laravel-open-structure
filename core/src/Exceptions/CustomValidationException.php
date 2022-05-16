<?php

namespace Core\Exceptions;

use Core\Exceptions\BaseException;
use Symfony\Component\HttpFoundation\Response;

class CustomValidationException extends BaseException
{
    protected int $statusCode = Response::HTTP_UNPROCESSABLE_ENTITY;

    protected string $attribute;

    /**
     * @param  string  $attribute
     * @param  string  $message
     * @param  int  $exceptionCode
     * @param  int|null  $statusCode
     */
    public function __construct(string $attribute, string $message = "", int $exceptionCode = 0, ?int $statusCode = null)
    {
        $this->attribute = $attribute;
        parent::__construct($message, $exceptionCode, $statusCode);
    }

    /**
     * @return string
     */
    public function getAttribute(): string
    {
        return $this->attribute;
    }
}
