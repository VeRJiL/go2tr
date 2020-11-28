<?php

namespace App\Jobs;

use DOMDocument;
use App\Models\Post;
use App\Models\Image;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class ProcessPostBody implements ShouldQueue
{
    use Queueable;
    use Dispatchable;
    use SerializesModels;
    use InteractsWithQueue;

    private Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    /**
     * Execute the job.
     *
     * @param Image $imageModel
     * @return void
     */
    public function handle(Image $imageModel)
    {
        // Content list
        $dom = new DomDocument();
        $dom->loadHTML($this->post->body);
        $headers = $dom->getElementsByTagName('h1');

        $headersList = [];
        foreach ($headers as $header) {
            $headersList[] = $header->textContent;
        }

        $this->post->content_list = $headersList;

        // Process Image tags and replace with proper values
        $imageTags = $dom->getElementsByTagName('img');
        foreach ($imageTags as $imageTag) {
            $imageRecordAtDB = $imageModel->where('unique_code', $imageTag->getAttribute('unique_code'))
                ->whereHas('variations', function ($query) {
                    $imageVariationTableName = config('table_names.image_variation');
                    return $query->where($imageVariationTableName . '.tag', 'original');
                })
                ->first();

            $imageTags->setAttribute('width', $imageRecordAtDB->width);
            $imageTags->setAttribute('height', $imageRecordAtDB->height);
            $imageTags->setAttribute('alt', $imageRecordAtDB->alt);
            $imageTags->setAttribute('title', $imageRecordAtDB->title);
            $imageTags->setAttribute('src', $imageRecordAtDB->url);
            $imageTags->setAttribute('loading', 'lazy');
        }

        // lazy loads iframes
        $dom->loadHTML($this->post->body);
        $iframes = $dom->getElementsByTagName('iframe');

        foreach ($iframes as $iframe) {
            $iframe->setAttribute('loading', 'lazy');
        }

        $processedContent = $dom->saveHTML();
        $this->post->processed_content = $processedContent;
        $this->post->save();
    }
}
