<?php

namespace App\Modules\Post\CommentOnPost;

use Core\Http\Requests\FormRequest;

class CommentOnPostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'content' => 'required|string|max:65535',
        ];
    }
}
