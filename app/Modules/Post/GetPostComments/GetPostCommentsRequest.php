<?php

namespace App\Modules\Post\GetPostComments;

use Core\Http\Requests\FormRequest;

class GetPostCommentsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'limit' => 'nullable|numeric',
            'page'  => 'nullable|numeric',
        ];
    }
}
