<?php

namespace App\Modules\File\GeneratePresigned;

use Core\Transformers\BaseTransformerCollection;
use Illuminate\Support\Collection;

class GeneratePresignedTransformer extends BaseTransformerCollection
{
    /**
     * @return array
     */
    public function data(): array
    {
        /** @var Collection $filenames */
        /** @var Collection $urls */
        [$filenames, $urls] = $this->collection;

        return $filenames->map(function ($filename, $index) use ($urls) {
            return [
                'filename'      => $filename,
                'presigned_url' => $urls[$index] ?? '',
            ];
        })
            ->toArray();
    }
}
