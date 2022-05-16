<?php

namespace Core\Transformers;

use Illuminate\Http\Resources\Json\ResourceCollection;

abstract class BaseTransformerCollection extends ResourceCollection
{
    abstract public function data(): array;
}
