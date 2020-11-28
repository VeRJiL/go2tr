<?php

namespace App\Http\Resources\V1;

use App\Enums\ImageTag;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ImageResourceCollection extends ResourceCollection
{
    /**
     * @param Request $request
     * @return array|Collection
     */
    public function toArray(Request $request)
    {
        return $this->collection->transform(function ($image) {
            $original = $image->variations()->where('tag', ImageTag::ORIGINAL)->first()->url;

            return [
                'title' => $image->title,
                'alt' => $image->alt,
                'url' => $original->url,
                'width' => $original->width,
                'height' => $original->height,
            ];
        });
    }
}
