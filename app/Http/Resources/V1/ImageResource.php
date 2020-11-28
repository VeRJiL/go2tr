<?php

namespace App\Http\Resources\V1;

use App\Enums\ImageTag;
use Illuminate\Http\Resources\Json\JsonResource;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $original = $this->variations()->where('tag', ImageTag::ORIGINAL)->first()->url;

        return [
            'title' => $this->title,
            'alt' => $this->alt,
            'url' => $original->url,
            'width' => $original->width,
            'height' => $original->height,
        ];
    }
}
