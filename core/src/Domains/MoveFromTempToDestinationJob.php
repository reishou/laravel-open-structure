<?php

namespace Core\Domains;

use Core\Enums\FileDirectoryType;
use Illuminate\Support\Facades\Storage;

class MoveFromTempToDestinationJob extends BaseJob
{
    /**
     * @param  string  $type
     * @param  int  $userId
     * @param  array  $filenames
     * @param  int  $instanceId
     */
    public function __construct(
        private string $type,
        private int $userId,
        private array $filenames,
        private int $instanceId = 0
    ) {
    }

    /**
     * @return void
     */
    public function handle(): void
    {
        $tempDirectory        = FileDirectoryType::getTempDirectory($this->type, $this->userId);
        $destinationDirectory = FileDirectoryType::getStorageDirectory($this->type, $this->userId, $this->instanceId);
        $disk                 = Storage::disk('s3');

        foreach ($this->filenames as $filename) {
            $source      = "$tempDirectory/$filename";
            $destination = "$destinationDirectory/$filename";

            $disk->move($source, $destination);
        }
    }
}
