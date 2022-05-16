<?php

namespace App\Modules\Post\UpdatePost;

use Core\Http\Requests\FormRequest;
use Core\Rules\Latitude;
use Core\Rules\Longitude;

class UpdatePostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'image_filenames'   => 'nullable|array',
            'image_filenames.*' => 'required|string',
            'content'           => 'nullable|string|max:65535',
            'caught_fish_at'    => 'nullable|date_format:Y-m-d H:i:s',
            'fish_species'      => 'nullable|string|max:255',
            'fish_size'         => 'nullable|string|max:255',
            'total_fishes'      => 'nullable|numeric',
            'latitude'          => ['nullable', new Latitude()],
            'longitude'         => ['nullable', new Longitude()],
        ];
    }
}
