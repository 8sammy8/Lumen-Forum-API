<?php

use Illuminate\Http\Request;
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->group(['prefix' => 'api'], function () use ($router) {

    $router->group(['middleware' => 'auth'], function () use ($router) {

        $router->get('/user', function (Request $request) {
            return $request->user();
        });
    });

    $router->group(['prefix' => 'topics'], function () use ($router) {

        $router->get('/', 'TopicController@index');
        $router->get('/{topic}', 'TopicController@show');
        $router->post('/', ['middleware' => 'auth', 'uses' => 'TopicController@store']);
        $router->patch('/{topic}', ['middleware' => 'auth', 'uses' => 'TopicController@update']);
        $router->delete('/{topic}', ['middleware' => 'auth', 'uses' => 'TopicController@destroy']);

        $router->group(['prefix' => '/{topic}/posts'], function () use ($router) {

            $router->post('/', ['middleware' => 'auth', 'uses' => 'PostController@store']);
            $router->patch('/{post}', ['middleware' => 'auth', 'uses' => 'PostController@update']);
            $router->delete('/{post}', ['middleware' => 'auth', 'uses' => 'PostController@destroy']);
        });
    });


    $router->post('/register', 'RegisterController@register');

});
