<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PostResourceCollection extends ResourceCollection
{
    /**
     * @param Request $request
     * @return array|Collection
     */
    public function toArray(Request $request)
    {
        return $this->collection->transform(function ($image) {
            return [
                'title' => $image->title,
                'alt' => $image->alt,
                'url' => $image->url,
                'width' => $image->width,
                'height' => $image->height,
            ];
        });
    }
}
