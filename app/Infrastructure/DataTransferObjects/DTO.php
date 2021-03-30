<?php

namespace App\Infrastructure\DataTransferObjects;

use ReflectionClass;

abstract class DTO
{
    protected array $onlyKeys = [];
    protected array $exceptKeys = [];

    public function all(): array
    {
        $data = [];

        $class = new ReflectionClass(static::class);

        $properties = $class->getProperties();

        foreach ($properties as $reflectionProperty) {
            // Skip static properties
            if ($reflectionProperty->isStatic()) {
                continue;
            }

            $data[$reflectionProperty->getName()] = $reflectionProperty->getValue($this);
        }

        return $data;
    }

    public function only(string ...$keys): DTO
    {
        $dto = clone $this;

        $dto->onlyKeys = [...$this->onlyKeys, ...$keys];

        return $dto;
    }

    public function except(string ...$keys): DTO
    {
        $dto = clone $this;

        $dto->exceptKeys = [...$this->exceptKeys, ...$keys];

        return $dto;
    }

    public function toArray(): array
    {
        if (count($this->onlyKeys)) {
            $array = Arr::only($this->all(), $this->onlyKeys);
        } else {
            $array = Arr::except($this->all(), $this->exceptKeys);
        }

        $array = $this->parseArray($array);

        return $array;
    }

    protected function parseArray(array $array): array
    {
        foreach ($array as $key => $value) {
            if ($value instanceof DTO) {
                $array[$key] = $value->toArray();

                continue;
            }

            if (!is_array($value)) {
                continue;
            }

            $array[$key] = $this->parseArray($value);
        }

        return $array;
    }
}
