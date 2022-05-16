<?php

namespace App\Modules\Feed\SearchUser;

use Core\Http\Requests\FormRequest;

class SearchUserRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'limit'   => 'nullable|numeric',
            'page'    => 'nullable|numeric',
            'keyword' => 'nullable|string',
        ];
    }
}
