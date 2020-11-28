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
        return $this->collection->transform(function ($post) {
            return [
                'title' => $post->title,
                'body' => $post->processed_content,
                'status' => $post->customStatus
            ];
        });
    }
}
