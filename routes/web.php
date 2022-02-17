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
    return 'Yellow Media Api';
});


$router->group(['namespace' => 'API\v0', 'prefix' => 'api/user'], function() use ($router)
{
    $router->post('/register', 'UserController@register');
    $router->post('/sign-in', 'UserController@signIn');
    $router->patch('/recover-password', 'UserController@recoverPassword');

    $router->group(['middleware' => 'auth'], function() use ($router) {
        $router->get('/companies', 'UserController@getCompanies');
        $router->post('/companies', 'UserController@storeCompanies');
    });
});
