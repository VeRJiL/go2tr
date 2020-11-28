<?php

namespace App\Http\Controllers\Image\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\ImageRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ImageResource;
use App\Services\Contracts\ImageServiceInterface;
use App\Http\Resources\V1\ImageResourceCollection;

class ImageController extends Controller
{
    private ImageServiceInterface $imageService;

    public function __construct(ImageServiceInterface $imageService)
    {
        $this->imageService = $imageService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(
            new ImageResourceCollection($this->imageService->all())
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ImageRequest $request
     * @return JsonResponse
     */
    public function store(ImageRequest $request)
    {
        return response()->json(
            $this->imageService->store($request)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        return response()->json(
            new ImageResource($this->imageService->find($id))
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ImageRequest $request
     * @param  int $id
     * @return JsonResponse
     */
    public function update(ImageRequest $request, int $id)
    {
        return response()->json(
            $this->imageService->update($request, $id)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        return response()->json(
            $this->imageService->destroy($id)
        );
    }
}
