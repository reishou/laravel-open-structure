<?php

namespace Core\Rules;

use Illuminate\Contracts\Validation\Rule;

class Longitude implements Rule
{
    /**
     * @param $attribute
     * @param $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        return preg_match('/^[-]?((((1[0-7][0-9])|([0-9]?[0-9]))\.(\d+))|180(\.0+)?)$/', $value);
    }

    /**
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute must be a valid set of longitude coordinates.';
    }
}