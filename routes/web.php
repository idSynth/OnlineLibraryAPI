<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

//$router->get('/books', 'BookController@index');

$router->group(['prefix' => 'api/'], function ($app) {
    $app->get('login/','UserController@authenticate');
    $app->post('signup/','UserController@register');
    $app->get('books/', 'BookController@index');
    $app->get('books/{id}/', 'BookController@show');
    $app->put('todo/{id}/', 'TodoController@update');
    $app->delete('todo/{id}/', 'TodoController@destroy');
});
