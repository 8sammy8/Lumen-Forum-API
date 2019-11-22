<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Topic;
use App\Transformers\PostTransformer;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;

class PostController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request, $topicId)
    {
        $post = new Post;
        $post->body = $request->body;
        $post->user()->associate($request->user());

        $topic = Topic::findOrFail($topicId);

        return ($topic->posts()->save($post))
            ? fractal()
                ->item($post)
                ->parseIncludes(['user'])
                ->transformWith(new PostTransformer)
                ->toArray()
            : response(null, 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdatePostRequest $request
     * @param  int  $topicId
     * @param  int  $postId
     * @return array|\Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdatePostRequest $request, $topicId, $postId)
    {
        $post = Post::findOrFail($postId);
        $post->body = $request->get('body', $request->body);

        return ($post && $this->authorize('update', $post) && $post->save())
            ? fractal()
                ->item($post)
                ->parseIncludes(['user'])
                ->transformWith(new PostTransformer)
                ->toArray()
            : response(null, 404);
    }

    /**
     * @param  int  $topicId
     * @param  int  $postId
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($topicId, $postId)
    {
        $post = Post::findOrFail($postId);

        return ($post && $this->authorize('destroy', $post) && $post->delete())
        ? response(null, 204)
        : response(null, 404);
    }
}
