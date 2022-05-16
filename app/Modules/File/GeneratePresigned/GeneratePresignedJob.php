<?php

namespace App\Modules\File\GeneratePresigned;

use Core\Domains\BaseJob;
use Illuminate\Filesystem\AwsS3V3Adapter;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;

class GeneratePresignedJob extends BaseJob
{
    /**
     * @param  Collection  $keys
     */
    public function __construct(private Collection $keys)
    {
    }

    /**
     * @return Collection
     */
    public function handle(): Collection
    {
        /** @var AwsS3V3Adapter $disk */
        $disk   = Storage::disk('s3');
        $client = $disk->getClient();

        return collect($this->keys)
            ->map(function ($key) use ($client) {
                $command = $client->getCommand('PutObject', [
                    'Bucket' => config('filesystems.disks.s3.bucket'),
                    'Key'    => $key,
                ]);

                $request = $client->createPresignedRequest($command, '+20 minutes');

                return (string) $request->getUri();
            });
    }
}
