<?php

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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

// Login & Register Routes 
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->post('/login', 'LoginController@login');
    $router->post('/register', 'RegisterController@register');
});

// Profile Routes
$router->group(['middleware' => 'auth:api', 'prefix' => 'api'], function() use ($router)
{
    $router->get('/user', ['uses' => 'ProfileController@show']);
    $router->patch('/user', ['uses' => 'ProfileController@update']);
    $router->delete('/user', ['uses' => 'ProfileController@destroy']);
});

// Upload Image Route
$router->group(['middleware' => 'auth:api', 'prefix' => 'api'], function() use ($router)
{
    $router->post('/upload', ['uses' => 'ImageController@upload']);
});

// Goal Routes With Middleware
// $router->group(['prefix' => 'api', 'middleware' => ['jwt.refresh', 'jwt.auth']], function () use ($router) {
//     $router->get('/goals',  ['uses' => 'GoalController@index']);
//     $router->get('/goal/{$id}', ['uses' => 'GoalController@show']);
//     $router->post('/goals', ['uses' => 'GoalController@create']);
//     $router->put('/goals/{$id}', ['uses' => 'GoalController@update']);
//     $router->delete('/goals/{$id}', ['uses' => 'GoalController@destroy']);
//   });