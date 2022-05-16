<?php

namespace Core\Rules;

use Illuminate\Contracts\Validation\Rule;

class Latitude implements Rule
{
    /**
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return preg_match('/^[-]?(([0-8]?[0-9])\.(\d+))|(90(\.0+)?)$/', $value);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute must be a valid set of latitude coordinates.';
    }
}