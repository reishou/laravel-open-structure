<?php

namespace Core\Transformers;

use Illuminate\Http\Resources\Json\JsonResource;

abstract class BaseTransformer extends JsonResource
{
    abstract public function data(): mixed;
}
