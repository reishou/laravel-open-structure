<?php

namespace App\Modules\Feed\GetFeeds;

use Core\Http\Requests\FormRequest;

class GetFeedsRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'limit' => 'nullable|numeric',
            'page'  => 'nullable|numeric',
        ];
    }
}
