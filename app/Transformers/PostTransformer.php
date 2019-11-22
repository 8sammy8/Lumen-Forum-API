<?php


namespace App\Transformers;

use App\Models\Post;

class PostTransformer extends Transformer
{
    /**
     * @var array
     */
    protected $availableIncludes = ['user', 'likes'];

    /**
     * @param Post $post
     * @return array
     */
    public function transform(Post $post)
    {
        return [
            'id' => $post->id,
            'body' => $post->body,
            'like_count' => $post->likes->count(),
            'created_at' => $post->created_at->toDateTimeString(),
            'created_at_human' => $post->created_at->diffForHumans()
        ];
    }

    /**
     * @param Post $post
     * @return \League\Fractal\Resource\Item
     */
    public function includeUser(Post $post)
    {
        return $this->item($post->user, new UserTransformer);
    }

    /**
     * @param Post $post
     * @return \League\Fractal\Resource\Collection
     */
    public function includeLikes(Post $post)
    {
        return $this->collection($post->likes->pluck('user'), new UserTransformer);
    }
}
