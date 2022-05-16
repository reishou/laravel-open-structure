<?php

namespace Core\Domains;

use App\Enums\FileDirectoryType;
use App\Exceptions\BusinessException;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class CheckTempFileExistsJob extends BaseJob
{
    /**
     * @param  string  $type
     * @param  int  $userId
     * @param  array  $filenames
     */
    public function __construct(private string $type, private int $userId, private array $filenames)
    {
    }

    /**
     * @throws Throwable
     */
    public function handle()
    {
        $directory = FileDirectoryType::getTempDirectory($this->type, $this->userId);
        $disk      = Storage::disk('s3');
        $notExist  = collect([]);

        foreach ($this->filenames as $filename) {
            $path = "$directory/$filename";
            if (!$disk->exists($path)) {
                $notExist->push($filename);
            }
        }

        throw_if(
            $notExist->isNotEmpty(),
            BusinessException::class,
            __('core.filenames_not_found', [
                'filenames' => $notExist->implode(', ')
            ]), 0, Response::HTTP_NOT_FOUND
        );
    }
}
