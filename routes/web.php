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
    return 'Default Entry Point';
});

$router->get('/hello', function () use ($router) {
    return 'Hello World';
});

// API route group
$router->group(['prefix' => 'api'], function () use ($router) {

    // UserController
    $router->get('/user/{id}', 'UserController@show');
    $router->get('/users', 'UserController@index');
    $router->put('/user/{id}', 'UserController@update');

    // CompactDiscController
    $router->post('/compact-disc', 'CompactDiscController@insert');
    $router->get('/compact-disc/{id}', 'CompactDiscController@show');
    $router->get('/compact-discs', 'CompactDiscController@index');
    $router->put('/compact-disc/{id}', 'CompactDiscController@update');
    $router->patch('/compact-disc/{id}', 'CompactDiscController@updateStock');

    // UserRentController
    $router->get('/user-rents', 'UserRentCompactDiscController@index');
    $router->get('/user-rents/detail', 'UserRentCompactDiscController@show_all_data');
    $router->post('/user-rent/rent', 'UserRentCompactDiscController@rent');
    $router->post('/user-rent/return', 'UserRentCompactDiscController@return');

    // AuthenticationController
    $router->post('/auth/register', 'AuthController@register');
    $router->post('/auth/login', 'AuthController@login');

    // UserPayRentController
    $router->post('/user-rent/pay', 'UserPayRentController@payRental');
 });


