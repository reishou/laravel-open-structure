<?php

namespace App\Modules\File\GeneratePresigned;

use App\Enums\FileDirectoryType;
use Core\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;

class GeneratePresignedFeature extends BaseFeatures
{
    /**
     * @param  GeneratePresignedRequest  $request
     * @return JsonResponse
     */
    public function handle(GeneratePresignedRequest $request): JsonResponse
    {
        $type      = (string) $request->input('type');
        $filenames = collect((array) $request->input('filenames'));

        $keys = $filenames->map(function ($filename) use ($type) {
            return $this->getPresignedKey($type, $filename, (int) Auth::id());
        });

        $urls = $this->getPresignedUrls($keys);

        return $this->success(new GeneratePresignedTransformer([$filenames, $urls]));
    }

    /**
     * @param  string  $type
     * @param  string  $filename
     * @param  int  $userId
     * @return string
     */
    public function getPresignedKey(string $type, string $filename, int $userId): string
    {
        $directory = FileDirectoryType::getTempDirectory($type, $userId);

        return "$directory/$filename";
    }

    /**
     * @param  Collection  $keys
     * @return Collection
     */
    protected function getPresignedUrls(Collection $keys): Collection
    {
        return $this->run(GeneratePresignedJob::class, compact('keys'));
    }
}
