<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Requests\StoreUserRequest;

class RegisterController extends Controller
{
    public function register (StoreUserRequest $request)
    {
    	$user = new User;

    	$user->username = $request->username;
    	$user->email    = $request->email;
    	$user->password = password_hash($request->password, PASSWORD_BCRYPT);

    	$user->save();
    }
}
