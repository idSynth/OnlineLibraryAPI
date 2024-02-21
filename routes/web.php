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
    $app->get('books', 'BookController@showAll');
    $app->get('books/{id}', 'BookController@showById');
});

$router->group(['prefix' => 'api/', 'middleware' => 'Authenticate'], function ($app) {
    $app->post('books/fav/{id}', 'UserController@addFavorite');
    $app->delete('books/fav/{id}', 'UserController@removeFavorite');
    $app->delete('books/{id}', 'BookController@remove');
    $app->get('books/csv', 'BookController@csvExport');
});

$router->group(['prefix' => 'api/', 'middleware' => ['Authenticate', 'AdminOnly']], function ($app) {
    $app->post('books/', 'BookController@add');
    $app->delete('books/{id}', 'BookController@remove');
    $app->get('books/csv', 'BookController');
});
