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

$router->get('/debug-sentry', function () {
    throw new Exception('My first Sentry error!');
});

$router->group(
    [
        'prefix' => 'api/v1',
    ],
    function () use ($router) {
        $router->get('users', 'UserController@index');
        $router->get('users/{id}', 'UserController@get');
        $router->post('users', 'UserController@create');
        $router->put('users/{id}', 'UserController@update');
        $router->delete('users/{id}', 'UserController@delete');
        $router->get('users/{id}/location', 'UserController@getCurrentLocation');
        $router->post('users/{id}/location/latitude/{latitude}/longitude/{longitude}', 'UserController@setCurrentLocation');
        $router->get('users/{id}/wallet', 'UserController@getWallet');
    }
);
