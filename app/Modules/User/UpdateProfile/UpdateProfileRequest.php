<?php

namespace App\Modules\User\UpdateProfile;

use Core\Http\Requests\FormRequest;

class UpdateProfileRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name'                     => 'nullable|string|max:255',
            'nickname'                 => 'nullable|string|max:255',
            'description'              => 'nullable|string|max:65535',
            'avatar'                   => 'nullable|string|max:255',
        ];
    }
}
