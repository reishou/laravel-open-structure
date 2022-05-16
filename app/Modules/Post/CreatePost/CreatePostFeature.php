<?php

namespace App\Modules\Post\CreatePost;

use App\Enums\FileDirectoryType;
use App\Models\Post;
use Core\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;

class CreatePostFeature extends BaseFeatures
{
    /**
     * @param  CreatePostRequest  $request
     * @return JsonResponse
     * @throws UnknownProperties
     */
    public function handle(CreatePostRequest $request): JsonResponse
    {
        $images    = (array) $request->input('images');
        $filenames = collect($images)
            ->pluck('filename')
            ->toArray();
        if (!empty($images)) {
            $this->validateUploadableImage($filenames, FileDirectoryType::POST_IMAGE, (int) Auth::id());
        }

        $post = $this->createPost($request, (int) Auth::id());

        if (!empty($images)) {
            $this->uploadImage($post, $filenames, FileDirectoryType::POST_IMAGE);
            $this->createImage($post, $images);
        }

        return $this->success(new CreatePostTransformer($post));
    }

    /**
     * @param  Post  $post
     * @param  array  $images
     * @return void
     */
    protected function createImage(Post $post, array $images): void
    {
        $collection = collect($images)->map(function ($image) use ($post) {
            $directory = FileDirectoryType::getStorageDirectory(
                FileDirectoryType::POST_IMAGE,
                $post->user_id,
                $post->id
            );
            $filename  = $image['filename'] ?? '';

            return new CreatePostImageDto(
                postId: $post->id,
                path: "$directory/$filename",
                width: (int) ($image['width'] ?? 0),
                height: (int) ($image['height'] ?? 0),
                createdAt: Carbon::now(),
                updatedAt: Carbon::now(),
            );
        });

        $this->run(CreatePostImageJob::class, compact('collection'));
    }

    /**
     * @param  Post  $post
     * @param  array  $filenames
     * @param  string  $directoryType
     * @return void
     */
    protected function uploadImage(Post $post, array $filenames, string $directoryType): void
    {
        $this->moveFromTempToDestination($filenames, $directoryType, $post->user_id, $post->id);
    }

    /**
     * @param  CreatePostRequest  $request
     * @param  int  $authenticatedUserId
     * @return Post
     * @throws UnknownProperties
     */
    protected function createPost(CreatePostRequest $request, int $authenticatedUserId): Post
    {
        $latitude  = (string) $request->input('latitude');
        $longitude = (string) $request->input('longitude');
        $location  = null;

        if (!empty($latitude) && !empty($longitude)) {
            $location = "POINT($longitude $latitude)";
        }

        $timeCaughtFish = (string) $request->input('caught_fish_at');
        $tz             = config('app.client_timezone');
        $caughtFishAt   = $this->createFromFormat('Y-m-d H:i:s', $timeCaughtFish, $tz);
        if ($caughtFishAt) {
            $caughtFishAt = $caughtFishAt->setTimezone(config('app.timezone'));
        }

        return $this->run(CreatePostJob::class, [
            'dto' => new CreatePostDto(
                userId: $authenticatedUserId,
                content: (string) $request->input('content'),
                caughtFishAt: $caughtFishAt,
                fishSpecies: (string) $request->input('fish_species'),
                fishSize: (string) $request->input('fish_size'),
                totalFishes: (string) $request->input('total_fishes'),
                latitude: $latitude,
                longitude: $longitude,
                location: $location
            ),
        ]);
    }

    /**
     * @param  array  $filenames
     * @param  string  $directoryType
     * @param  int  $authenticatedUserId
     * @return void
     */
    protected function validateUploadableImage(array $filenames, string $directoryType, int $authenticatedUserId): void
    {
        $this->checkTempFileExists($filenames, $directoryType, $authenticatedUserId);
    }
}
