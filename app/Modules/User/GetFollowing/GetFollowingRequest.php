<?php

namespace App\Modules\User\GetFollowing;

use Core\Http\Requests\FormRequest;

class GetFollowingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'limit' => 'nullable|numeric',
            'page'  => 'nullable|numeric',
        ];
    }
}
