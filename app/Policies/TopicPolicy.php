<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicPolicy
{
    use HandlesAuthorization;

    /**
     * @param User $user
     * @param Topic $topic
     * @return bool
     */
    public function update(User $user, Topic $topic)
    {
        return $user->ownsTopic($topic);
    }

    /**
     * @param User $user
     * @param Topic $topic
     * @return bool
     */
    public function destroy(User $user, Topic $topic)
    {
        return $user->ownsTopic($topic);
    }
}
