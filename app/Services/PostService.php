<?php

namespace App\Services;

use App\Models\Post;
use App\Acme\BaseAnswer;
use App\Jobs\ProcessPostBody;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\DB;
use App\Services\Contracts\PostServiceInterface;

class PostService extends Service implements PostServiceInterface
{
    private Post $post;

    public function __construct(Post $post)
    {
        $this->post = $post;
    }

    public function find(int $id): BaseAnswer
    {
        return successAnswer(
            $this->post->findOrFail($id)
        );
    }

    public function all(): BaseAnswer
    {
        return successAnswer(
            $this->post->all()
        );
    }

    public function store(PostRequest $request): BaseAnswer
    {
        // Process the body and then save it
        DB::transaction(function () use ($request) {
            $post = $this->post->create($request->only($this->allowedInputs()));
            ProcessPostBody::dispatch($post);
        });

        return successAnswer();
    }

    public function update(PostRequest $request, int $id): BaseAnswer
    {
        $post = $this->post->findOrFail($id);

        DB::transaction(function () use ($post, $request) {
            $post->update($request->only($this->allowedInputs()));
            ProcessPostBody::dispatch($post);
        });

        return successAnswer();
    }

    public function destroy(int $id): BaseAnswer
    {
        $post = $this->post->findOrFail($id);
        $post->destroy();

        return successAnswer();
    }

    public function changeStatus(int $id): BaseAnswer
    {
        $post = $this->post->findOrFail($id);
        $post->status = !$post->status;
        $post->save();

        return successAnswer();
    }

    private function allowedInputs()
    {
        return ['title', 'body'];
    }
}
