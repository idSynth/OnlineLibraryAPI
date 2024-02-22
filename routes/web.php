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



$router->group(['prefix' => 'api/'], function ($app) {
    $app->get('login/','UserController@authenticate');
    $app->post('signup/','UserController@register');
    $app->get('books', 'BookController@showAll');
    $app->get('books/{id:[0-9]+}', 'BookController@showById');
});

$router->group(['prefix' => 'api/', 'middleware' => \App\Http\Middleware\Authenticate::class], function ($app) {
    $app->post('books/fav/{id:[0-9]+}', 'UserController@addFavorite');
    $app->get('books/fav', 'UserController@getFavorite');
    $app->delete('books/fav/{id:[0-9]+}', 'UserController@removeFavorite');
});

$router->group(['prefix' => 'api/', 'middleware' => [\App\Http\Middleware\Authenticate::class, \App\Http\Middleware\AdminOnly::class]], function ($app) {
    $app->post('books/', 'BookController@add');
    $app->get('books/csv', 'BookController@csvExport');
    $app->delete('books/{id:[0-9]+}', 'BookController@remove');
});
