<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class PostLikeController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @param  int  $topicId
     * @param  int  $postId
     * @return \Illuminate\Http\Response|\Laravel\Lumen\Http\ResponseFactory
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(Request $request, $topicId, $postId)
    {
        $like = new Like;
        $like->user()->associate($request->user());

        $post = Post::findOrFail($postId);

        $this->authorize('like', $post);

        if($request->user()->hasLikedPost($post))
        {
            return response(null, 409);
        }

        return ($post && $post->likes()->save($like))
            ? response(null, 204)
            : response(null, 404);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
