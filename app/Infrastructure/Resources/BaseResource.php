<?php

namespace App\Infrastructure\Resources;

use Illuminate\Http\Resources\Json\ResourceResponse;

abstract class BaseResource extends ResourceResponse
{
//    public function toResponse($request)
//    {
//        return tap(response()->json(
//            $this->wrap(
//                $this->resource->resolve($request),
//                $this->resource->with($request),
//                $this->resource->additional
//            ),
//            $this->calculateStatus()
//        ), function ($response) use ($request) {
//            $response->original = $this->resource->resource;
//
//            $this->resource->withResponse($request, $response);
//        });
//    }
}
