<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Post;
use Illuminate\Auth\Access\HandlesAuthorization;

class PostPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function update(User $user, Post $post)
    {
        return $user->ownsPost($post);
    }

    /**
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function destroy(User $user, Post $post)
    {
        return $user->ownsPost($post);
    }

    /**
     * @param User $user
     * @param Post $post
     * @return bool
     */
    public function like(User $user, Post $post)
    {
        return !$user->ownsPost($post);
    }
}
