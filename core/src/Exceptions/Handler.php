<?php

namespace Core\Exceptions;

use Core\Enums\BaseExceptionCode;
use Core\Http\ResponseTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Psr\Log\LogLevel;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    use ResponseTrait;

    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<Throwable>, LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * @param  Request    $request
     * @param  Throwable  $e
     * @return JsonResponse
     */
    public function render($request, Throwable $e): JsonResponse
    {
        if ($e instanceof AuthenticationException) {
            return $this->authenticationException($e);
        }

        if ($e instanceof AuthorizationException) {
            return $this->authorizationException($e);
        }

        if ($e instanceof ValidationException) {
            return $this->validationException($e);
        }

        if ($e instanceof CustomValidationException) {
            return $this->customValidationException($e);
        }

        if ($e instanceof ModelNotFoundException) {
            return $this->modelNotFoundException($e);
        }

        if ($e instanceof HttpException) {
            return $this->httpException($e);
        }

        $this->addError($e->getMessage());

        return $this->error();
    }

    /**
     * @param  AuthenticationException  $e
     * @return JsonResponse
     */
    protected function authenticationException(AuthenticationException $e): JsonResponse
    {
        $this->addError($e->getMessage(), BaseExceptionCode::UNAUTHENTICATED->value);

        return $this->error(Response::HTTP_UNAUTHORIZED);
    }

    /**
     * @param  AuthorizationException  $e
     * @return JsonResponse
     */
    protected function authorizationException(AuthorizationException $e): JsonResponse
    {
        $this->addError($e->getMessage(), BaseExceptionCode::UNAUTHORIZED->value);

        return $this->error(Response::HTTP_FORBIDDEN);
    }

    /**
     * @param  ValidationException  $e
     * @return JsonResponse
     */
    protected function validationException(ValidationException $e): JsonResponse
    {
        foreach ($e->errors() as $attribute => $messages) {
            foreach ($messages as $message) {
                $this->addError($message, $e->getCode(), ['attribute' => $attribute]);
            }
        }

        return $this->error(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @param  CustomValidationException  $e
     * @return JsonResponse
     */
    protected function customValidationException(CustomValidationException $e): JsonResponse
    {
        $this->addError($e->getMessage(), $e->getCode(), ['attribute' => $e->getAttribute()]);

        return $this->error($e->getStatusCode());
    }

    /**
     * @param  ModelNotFoundException  $e
     * @return JsonResponse
     */
    protected function modelNotFoundException(ModelNotFoundException $e): JsonResponse
    {
        $this->addError(__('core.model_not_found', [
            'model' => Str::replace('App\\Models\\', '', $e->getModel()),
            'id'    => implode(',', $e->getIds()),
        ]), $e->getCode());

        return $this->error(Response::HTTP_NOT_FOUND);
    }

    /**
     * @param  HttpException  $e
     * @return JsonResponse
     */
    protected function httpException(HttpException $e): JsonResponse
    {
        $message = $e->getMessage();
        if ($e instanceof NotFoundHttpException) {
            $message = 'The requested URL was not found on this server.';
        }

        $this->addError($message, $e->getCode());

        return $this->error($e->getStatusCode());
    }
}
