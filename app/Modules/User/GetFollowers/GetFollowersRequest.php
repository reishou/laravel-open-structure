<?php

namespace App\Modules\User\GetFollowers;

use Core\Http\Requests\FormRequest;

class GetFollowersRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'limit' => 'nullable|numeric',
            'page'  => 'nullable|numeric',
        ];
    }
}
