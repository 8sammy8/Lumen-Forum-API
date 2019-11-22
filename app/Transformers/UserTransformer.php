<?php


namespace App\Transformers;

use App\Models\User;

class UserTransformer extends Transformer
{
    /**
     * @param User $user
     * @return array
     */
    public function transform(User $user)
    {
        return [
            'user' => $user->username,
            'avatar' => $user->avatar(),
        ];
    }
}
