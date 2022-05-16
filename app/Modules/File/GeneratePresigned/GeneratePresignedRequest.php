<?php

namespace App\Modules\File\GeneratePresigned;

use App\Enums\FileDirectoryType;
use BenSampo\Enum\Rules\EnumValue;
use Core\Http\Requests\FormRequest;

class GeneratePresignedRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'type'        => ['required', new EnumValue(FileDirectoryType::class, false)],
            'filenames'   => 'required|array',
            'filenames.*' => 'required|string',
        ];
    }
}
