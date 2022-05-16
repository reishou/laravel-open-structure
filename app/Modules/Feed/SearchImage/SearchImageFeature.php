<?php

namespace App\Modules\Feed\SearchImage;

use Core\Services\BaseFeatures;
use Illuminate\Http\JsonResponse;

class SearchImageFeature extends BaseFeatures
{
    /**
     * @param  SearchImageRequest  $request
     * @return JsonResponse
     */
    public function handle(SearchImageRequest $request): JsonResponse
    {
        $images = $this->getImages($request);

        return $this->success(new SearchImageTransformer($images));
    }

    /**
     * @param  SearchImageRequest  $request
     * @return mixed
     */
    protected function getImages(SearchImageRequest $request): mixed
    {
        return $this->run(SearchImageJob::class, [
            'criteria' => [
                'keyword' => (string) $request->input('keyword'),
            ],
            'limit'    => $this->getLimit($request),
            'with'     => [
                'post',
            ],
        ]);
    }
}
