<?php

namespace App\Http\Controllers\Post\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\PostRequest;
use App\Http\Controllers\Controller;
use App\Services\Contracts\PostServiceInterface;
use App\Http\Resources\V1\PostResourceCollection;

class PostController extends Controller
{
    private PostServiceInterface $postService;

    public function __construct(PostServiceInterface $postService)
    {
        $this->postService = $postService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        return response()->json(
            new PostResourceCollection($this->postService->all()->getData())
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PostRequest $request
     * @return JsonResponse
     */
    public function store(PostRequest $request)
    {
        return response()->json(
            $this->postService->store($request)
        );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function show(int $id)
    {
        return response()->json(
            $this->postService->find($id)
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  PostRequest $request
     * @param  int  $id
     * @return JsonResponse
     */
    public function update(PostRequest $request, int $id)
    {
        return response()->json(
            $this->postService->update($request, $id)
        );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return JsonResponse
     */
    public function destroy(int $id)
    {
        return response()->json(
            $this->postService->destroy($id)
        );
    }

    public function changeStatus(int $id)
    {
        return response()->json(
            $this->postService->changeStatus($id)
        );
    }
}
