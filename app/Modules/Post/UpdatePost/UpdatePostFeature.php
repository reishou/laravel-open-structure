<?php

namespace App\Modules\Post\UpdatePost;

use App\Enums\ExceptionCode;
use App\Enums\FileDirectoryType;
use App\Exceptions\BusinessException;
use App\Models\Post;
use Core\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Spatie\DataTransferObject\Exceptions\UnknownProperties;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class UpdatePostFeature extends BaseFeatures
{
    /**
     * @param  int  $id
     */
    public function __construct(private int $id)
    {
    }

    /**
     * @param  UpdatePostRequest  $request
     * @return JsonResponse
     * @throws Throwable
     */
    public function handle(UpdatePostRequest $request): JsonResponse
    {
        $post = $this->validateUpdatablePost($this->id, (int) Auth::id());

        $filenames = (array) $request->input('image_filenames');
        if (!empty($filenames)) {
            $this->validateUploadableImage($filenames, FileDirectoryType::POST_IMAGE, (int) Auth::id());
        }

        $this->updatePost($request, $this->id);

        if (!empty($filenames)) {
            $this->uploadImage($post, $filenames, FileDirectoryType::POST_IMAGE);
            $this->createImage($post, $filenames);
        }

        return $this->success(true);
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
     * @param  array  $filenames
     * @param  string  $directoryType
     * @param  int  $authenticatedUserId
     * @return void
     */
    protected function validateUploadableImage(array $filenames, string $directoryType, int $authenticatedUserId): void
    {
        $this->checkTempFileExists($filenames, $directoryType, $authenticatedUserId);
    }

    /**
     * @param  UpdatePostRequest  $request
     * @param  int  $id
     * @return void
     * @throws UnknownProperties
     */
    protected function updatePost(UpdatePostRequest $request, int $id): void
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

        $this->run(UpdatePostJob::class, [
            'dto' => new UpdatePostDto(
                id: $id,
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
     * @param  int  $id
     * @param  int  $authenticatedUserId
     * @return Post
     * @throws Throwable
     */
    protected function validateUpdatablePost(int $id, int $authenticatedUserId): Post
    {
        /** @var Post $post */
        $post = $this->findOrFail(Post::class, $id);

        throw_if(
            $post->user_id != $authenticatedUserId,
            BusinessException::class,
            __('business.post.post_access_denied'),
            ExceptionCode::POST_ACCESS_DENIED,
            Response::HTTP_FORBIDDEN
        );

        return $post;
    }

    /**
     * @param  Post  $post
     * @param  array  $filenames
     * @return void
     */
    protected function createImage(Post $post, array $filenames): void
    {
        $collection = collect($filenames)->map(function ($filename) use ($post) {
            $directory = FileDirectoryType::getStorageDirectory(
                FileDirectoryType::POST_IMAGE,
                $post->user_id,
                $post->id
            );

            return new CreatePostImageDto(
                postId: $post->id,
                path: "$directory/$filename",
                createdAt: Carbon::now(),
                updatedAt: Carbon::now(),
            );
        });

        $this->run(CreatePostImageJob::class, compact('collection'));
    }
}
