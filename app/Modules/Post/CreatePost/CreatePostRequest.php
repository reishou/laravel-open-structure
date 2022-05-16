<?php

namespace App\Modules\Post\CreatePost;

use Core\Http\Requests\FormRequest;
use Core\Rules\Latitude;
use Core\Rules\Longitude;

class CreatePostRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'images'            => 'nullable|array',
            'images.*.width'    => 'required|numeric',
            'images.*.height'   => 'required|numeric',
            'images.*.filename' => 'required|string',
            'content'           => 'required|string|max:65535',
            'caught_fish_at'    => 'required|date_format:Y-m-d H:i:s',
            'fish_species'      => 'required|string|max:255',
            'fish_size'         => 'required|string|max:255',
            'total_fishes'      => 'required|numeric',
            'latitude'          => ['nullable', new Latitude()],
            'longitude'         => ['nullable', new Longitude()],
        ];
    }
}
