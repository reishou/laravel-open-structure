<?php

namespace App\Exceptions;

use Core\Exceptions\BusinessException as BaseBusinessException;
use Symfony\Component\HttpFoundation\Response;

class BusinessException extends BaseBusinessException
{
    protected int $statusCode = Response::HTTP_BAD_REQUEST;
}
