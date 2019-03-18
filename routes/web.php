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
$router->group(['prefix' => 'api', 'middleware' => 'auth:api'], function () use ($router) {
    $router->get('/goal',  ['uses' => 'GoalController@index']);
    $router->get('/goals', ['uses' => 'GoalController@showAllGoals']);
    $router->get('/goal/{id}', ['uses' => 'GoalController@showOneGoal']);
    $router->post('/goal', ['uses' => 'GoalController@create']);
    $router->patch('/goal/{id}', ['uses' => 'GoalController@update']);
    $router->delete('/goal/{id}', ['uses' => 'GoalController@destroy']);
  });


  $router->get("ical-goal", "ICalController@getGoalsICalObject");

  // Task Routes With Middleware
$router->group(['prefix' => 'api', 'middleware' => 'auth:api'], function () use ($router) {
    $router->get('/task',  ['uses' => 'TaskController@index']);
    $router->get('{goal_id}/task', ['uses' => 'TaskController@showAllTasks']);
    $router->get('{goal_id}/task/{id}', ['uses' => 'TaskController@showOneTask']);
    $router->post('{goal_id}/task', ['uses' => 'TaskController@create']);
    $router->patch('{goal_id}/task/{id}', ['uses' => 'TaskController@update']);
    $router->delete('{goal_id}/task/{id}', ['uses' => 'TaskController@destroy']);
  });