<?php

namespace Core\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class BusinessException extends BaseException
{
    protected int $statusCode = Response::HTTP_BAD_REQUEST;
}
