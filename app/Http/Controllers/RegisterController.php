<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Transformers\UserTransformer;

class RegisterController extends Controller
{
    /**
     * @param StoreUserRequest $request
     * @return array
     */
    public function register (StoreUserRequest $request)
    {
    	$user = new User;

    	$user->username = $request->username;
    	$user->email    = $request->email;
    	$user->password = password_hash($request->password, PASSWORD_BCRYPT);

    	$user->save();

    	return fractal()
            ->item($user)
            ->transformWith(new UserTransformer)
            ->toArray();
    }
}
