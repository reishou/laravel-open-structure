<?php

namespace Core\ValueObjects;

use JsonSerializable;

class Price implements JsonSerializable
{
    /**
     * @param  string  $amount
     * @param  int  $scale
     */
    public function __construct(private string $amount = '0.0', private int $scale = 2)
    {
    }

    /**
     * @param  string  $amount
     * @param  int  $scale
     * @return Price
     */
    public static function create(string $amount = '0.0', int $scale = 2): Price
    {
        return new self($amount, $scale);
    }

    /**
     * @return string
     */
    public function amount(): string
    {
        return $this->amount;
    }

    /**
     * @param  mixed  $amount
     */
    public function add(mixed $amount)
    {
        $this->bcmath('bcadd', $amount);
    }

    /**
     * @param  mixed  $amount
     */
    public function sub(mixed $amount)
    {
        $this->bcmath('bcsub', $amount);
    }

    /**
     * @param  mixed  $amount
     */
    public function multiply(mixed $amount)
    {
        $this->bcmath('bcmul', $amount);
    }

    /**
     * @param  mixed  $amount
     */
    public function divide(mixed $amount)
    {
        $this->bcmath('bcdiv', $amount);
    }

    /**
     * @param  callable  $callback
     * @param  mixed  $amount
     */
    protected function bcmath(callable $callback, mixed $amount)
    {
        if ($amount instanceof Price) {
            $amount = $amount->amount();
        }

        $this->amount = call_user_func($callback, $this->amount, (string)$amount, $this->scale);
    }

    /**
     * @return Price
     */
    public function clone(): Price
    {
        return clone $this;
    }

    /**
     * @return string
     */
    public function jsonSerialize(): string
    {
        return $this->amount;
    }

    /**
     * @return bool
     */
    public function isPositive(): bool
    {
        return $this->amount > 0;
    }
}
