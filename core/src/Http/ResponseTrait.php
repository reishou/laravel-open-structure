<?php

namespace Core\Http;

use Core\Transformers\BaseTransformer;
use Core\Transformers\BaseTransformerCollection;
use Illuminate\Http\JsonResponse;
use Illuminate\Pagination\CursorPaginator;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Arr;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

/**
 *
 */
trait ResponseTrait
{
    /**
     * @var mixed
     */
    public mixed $response;
    /**
     * @var mixed
     */
    public mixed $data;
    /**
     * @var Throwable|null
     */
    public ?Throwable $exception;
    /**
     * @var array
     */
    public array $headers = [];
    /**
     * @var int
     */
    public int $statusCode;
    /**
     * @var mixed
     */
    public mixed $meta;
    /**
     * @var mixed|array
     */
    public mixed $included = [];
    /**
     * @var array
     */
    public array $errors = [];

    /**
     * @param  string  $key
     * @param  mixed  $included
     * @return void
     */
    public function addIncluded(string $key, mixed $included): void
    {
        Arr::set($this->included, $key, $included);
        $this->transformIncluded($key, $included);
    }

    /**
     * @param  string  $key
     * @param  mixed  $data
     * @return void
     */
    protected function addToResponse(string $key, mixed $data): void
    {
        Arr::set($this->response, $key, $data);
    }
    
    /**
     * @param  int  $statusCode
     */
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @param  mixed  $meta
     */
    public function setMeta(mixed $meta): void
    {
        $this->meta = $meta;
        $this->addToResponse('meta', $meta);
    }

    /**
     * @param  string  $message
     * @param  int  $exceptionCode
     * @param  array  $mixed
     * @return $this
     */
    public function addError(string $message, int $exceptionCode = 0, array $mixed = []): static
    {
        $error = [
            'code'    => $exceptionCode,
            'message' => $message,
        ];

        // add custom data to error
        $error = array_merge($error, $mixed);

        ksort($error);
        $this->errors[] = $error;

        return $this;
    }

    /**
     * @param  int  $statusCode
     * @return JsonResponse
     */
    public function error(int $statusCode = Response::HTTP_INTERNAL_SERVER_ERROR): JsonResponse
    {
        $this->setStatusCode($statusCode);
        $this->addToResponse('errors', $this->errors);

        return $this->response();
    }

    /**
     * @param  mixed  $data
     * @param  int  $statusCode
     * @return JsonResponse
     */
    public function success(mixed $data, int $statusCode = 200): JsonResponse
    {
        $this->data = $data;

        $this->transformData($data);
        $this->setStatusCode($statusCode);

        return $this->response();
    }

    /**
     * @param  mixed  $data
     * @return void
     */
    protected function transformData(mixed $data): void
    {
        if ($data instanceof BaseTransformer) {
            $this->addToResponse('data', $data->data());

            return;
        }

        if ($data instanceof BaseTransformerCollection) {
            $this->transformResourceCollection($data);

            return;
        }

        if ($data instanceof LengthAwarePaginator || $data instanceof CursorPaginator) {
            $this->transformPaginator($data);

            return;
        }

        $this->addToResponse('data', $data);
    }

    /**
     * @param  string  $key
     * @param  mixed  $included
     * @return void
     */
    protected function transformIncluded(string $key, mixed $included): void
    {
        if ($included instanceof BaseTransformer || $included instanceof BaseTransformerCollection) {
            $this->addToResponse('include.' . $key, $included->data());

            return;
        }

        $this->addToResponse('include.' . $key, $included);
    }

    /**
     * @param  LengthAwarePaginator|CursorPaginator  $paginator
     * @return void
     */
    protected function transformPaginator(LengthAwarePaginator|CursorPaginator $paginator): void
    {
        $this->addToResponse('meta', $this->getPaginatorMeta($paginator));

        $this->addToResponse('data', $paginator->getCollection());
    }

    /**
     * @param  BaseTransformerCollection  $resourceCollection
     * @return void
     */
    protected function transformResourceCollection(BaseTransformerCollection $resourceCollection): void
    {
        if ($resourceCollection->resource instanceof LengthAwarePaginator || $resourceCollection->resource instanceof CursorPaginator) {
            $this->addToResponse('meta', $this->getPaginatorMeta($resourceCollection->resource));
        }

        $this->addToResponse('data', $resourceCollection->data());
    }

    /**
     * @param  LengthAwarePaginator|CursorPaginator  $paginator
     * @return array
     */
    protected function getPaginatorMeta(LengthAwarePaginator|CursorPaginator $paginator): array
    {
        $meta = Arr::only($paginator->toArray(), [
            'current_page',
            'from',
            'last_page',
            'per_page',
            'to',
            'total',
        ]);

        if ($paginator instanceof CursorPaginator) {
            $meta = array_merge($meta, [
                'next_cursor' => $paginator->nextCursor()?->encode(),
                'prev_cursor' => $paginator->previousCursor()?->encode(),
                'has_more'    => $paginator->hasMorePages(),
            ]);
        }

        return $meta;
    }

    /**
     * @return JsonResponse
     */
    public function response(): JsonResponse
    {
        $response = $this->response;
        ksort($response);

        return response()->json($response, $this->statusCode, $this->headers);
    }
}
