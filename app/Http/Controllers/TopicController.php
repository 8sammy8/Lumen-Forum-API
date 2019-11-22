<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Topic;
use App\Transformers\TopicTransformer;
use App\Http\Requests\StoreTopicRequest;
use App\Http\Requests\UpdateTopicRequest;
use League\Fractal\Pagination\IlluminatePaginatorAdapter;

class TopicController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        $topics = Topic::latestFirst()->paginate(3);
        $topicsCollection = $topics->getCollection();

        return fractal()
            ->collection($topicsCollection)
            ->parseIncludes(['user', 'posts', 'posts.user'])
            ->transformWith(new TopicTransformer)
            ->paginateWith(new IlluminatePaginatorAdapter($topics))
            ->toArray();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTopicRequest $request
     * @return array|\Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function store(StoreTopicRequest $request)
    {
        $topic = new Topic;
        $topic->title = $request->title;
        $topic->user()->associate($request->user());

        $post = new Post;
        $post->body = $request->body;
        $post->user()->associate($request->user());

        if($topic->save() && $topic->posts()->save($post)){
            return fractal()
                ->item($topic)
                ->parseIncludes(['user', 'posts', 'posts.user'])
                ->transformWith(new TopicTransformer)
                ->toArray();
        }
        return response(null, 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return array|\Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     */
    public function show(int $id)
    {
        $topic = Topic::findOrFail($id);

        if($topic){
            return fractal()
                ->item($topic)
                ->parseIncludes(['user', 'posts', 'posts.user', 'posts.likes'])
                ->transformWith(new TopicTransformer)
                ->toArray();
        }
        return response(null, 404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  UpdateTopicRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(UpdateTopicRequest $request, $id)
    {
        $topic = Topic::findOrFail($id);

        if($topic)
        {
            $this->authorize('update', $topic);

            $topic->title = $request->get('title', $topic->title);

            $topic->save();

            return fractal()
                ->item($topic)
                ->parseIncludes(['user', 'posts', 'posts.user'])
                ->transformWith(new TopicTransformer)
                ->toArray();
        }
        return response(null, 404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     * @throws \Illuminate\Auth\Access\AuthorizationException
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy($id)
    {
        $topic = Topic::findOrFail($id);

        if($topic)
        {
            $this->authorize('destroy', $topic);

            if($topic->delete())
            {
                return response(null, 204);
            }
        }
        return response(null, 404);
    }
}
