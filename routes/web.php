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
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/users', 'ProfileController@showAllUsers');
    $router->get('/user/{id}', 'ProfileController@showOneUser');
    $router->put('/user/{id}', 'ProfileController@update');
    $router->delete('/user/{id}', 'ProfileController@destroy');
});

// Goal Routes without middleware
$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('/goals',  ['uses' => 'GoalController@index']);
    $router->get('/goal/{$id}', ['uses' => 'GoalController@show']);
    $router->post('/goals', ['uses' => 'GoalController@create']);
    $router->put('/goals/{$id}', ['uses' => 'GoalController@update']);
    $router->delete('/goals/{$id}', ['uses' => 'GoalController@destroy']);
});

// Goal Routes With Middleware
// $router->group(['prefix' => 'api', 'middleware' => ['jwt.refresh', 'jwt.auth']], function () use ($router) {
//     $router->get('/goals',  ['uses' => 'GoalController@index']);
//     $router->get('/goal/{$id}', ['uses' => 'GoalController@show']);
//     $router->post('/goals', ['uses' => 'GoalController@create']);
//     $router->put('/goals/{$id}', ['uses' => 'GoalController@update']);
//     $router->delete('/goals/{$id}', ['uses' => 'GoalController@destroy']);
//   });