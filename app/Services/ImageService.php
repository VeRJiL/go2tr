<?php

namespace App\Services;

use App\Models\Image;
use App\Enums\ImageTag;
use App\Acme\BaseAnswer;
use Illuminate\Http\Request;
use App\Models\ImageVariation;
use Illuminate\Support\Facades\DB;
use App\Models\Image as ImageModel;
use App\Http\Requests\ImageRequest;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManagerStatic;
use App\Services\Contracts\ImageServiceInterface;

class ImageService extends Service implements ImageServiceInterface
{
    private ImageModel $image;

    public function __construct(ImageModel $image)
    {
        $this->image = $image;
    }

    public function find(int $id): BaseAnswer
    {
        return successAnswer(
            $this->image->findOrFail($id)
        );
    }

    public function all()
    {
        return successAnswer(
            $this->image->all()
        );
    }

    public function store(ImageRequest $request): BaseAnswer
    {
        DB::transaction(function () use ($request) {
            $originalResult = $this->uploadOriginal($request)->getData();
            $lowQualityResult = $this->uploadLowQuality($request)->getData();

            $imageObject = $this->createImage($request)->getData();

            $this->createVariations($imageObject, $originalResult, $lowQualityResult);

            return successAnswer(null, $this->findMessage('store_succeed', 'image'));
        });

        return failAnswer($this->findMessage('store_failed', 'image'));
    }

    public function update(ImageRequest $request, $id)
    {
        $image = $this->image->findOrFail($id);

        $image->update($request->only($this->allowedInputs()));

        return successAnswer(null, $this->findMessage('updating_succeed', 'image'));
    }

    public function destroy(int $id): BaseAnswer
    {
        $image = $this->image->findOrFail($id);

        DB::transaction(function () use ($image, $id) {
            foreach ($image->variations as $variation) {
                $this->deleteImage($variation);
                $image->destroy();
            }

            $image->destroy();
        });

        return successAnswer();
    }

    private function createImage($request): BaseAnswer
    {
        $imageObject = $this->image->create(
            $request->only($this->allowedInputs()),
        );

        return successAnswer($imageObject);
    }

    private function createVariations($imageObject, $originalResult, $lowQualityResult): BaseAnswer
    {
        //TODO: wrap it with try catch
        $imageObject->variations()->create($originalResult);
        $imageObject->variations()->create($lowQualityResult);

        //returning success all the time for now
        return successAnswer();
    }

    private function deleteImage($image): BaseAnswer
    {
        $fileImage = ImageManagerStatic::make($image->path);
        $fileImage->destroy();

        return successAnswer(null,$this->findMessage('destruction_succeed', 'image'));
    }

    private function uploadOriginal($request): BaseAnswer
    {
        return $this->saveImage($request->file('image'), ImageTag::ORIGINAL);
    }

    private function uploadLowQuality($request): BaseAnswer
    {
        return $this->saveImage($request->file('image'), ImageTag::LOW_QUALITY, 50);
    }

    private function saveImage($file, $tag, $quality = 100): BaseAnswer
    {
        $this->makeDirectory();
        $image = ImageManagerStatic::make($file);
        $fileName = $tag . '-' . time() . '-' . $file->getClientOriginalName();
        $basePath = storage_path('app' . DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'images');
        $path = $basePath . DIRECTORY_SEPARATOR . $fileName;
        $image->save($path, $quality);

        $data = [
            'width' => $image->width(),
            'height' => $image->height(),
            'name' => $fileName,
            'tag' => $tag
        ];

        return successAnswer($data);
    }

    private function makeDirectory()
    {
        Storage::disk('local')->makeDirectory('public' . DIRECTORY_SEPARATOR .'images');
    }

    private function allowedInputs(): array
    {
        return ['title', 'alt'];
    }
}
