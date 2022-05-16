<?php

namespace App\Modules\Feed\SearchImage;

use Core\Http\Requests\FormRequest;

class SearchImageRequest extends FormRequest
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
