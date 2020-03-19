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

$router->get('/hello', function () use ($router) {
    return 'Hello World';
});

// API route group
$router->group(['prefix' => 'api'], function () use ($router) {

    // UserController
    $router->get('/user/{id}', 'UserController@show');
    $router->get('/user', 'UserController@index');
    $router->put('/user/{id}', 'UserController@update');
    
    // CompactDiscController
    $router->post('/compact-disc', 'CompactDiscController@insert');
    $router->get('/compact-disc/{id}', 'CompactDiscController@show');
    $router->get('/compact-disc', 'CompactDiscController@index');
    $router->put('/compact-disc/{id}', 'CompactDiscController@update');
    $router->patch('/compact-disc/{id}', 'CompactDiscController@updateStock');
    
    // UserRentController
    $router->get('/user-rent', 'UserRentCompactDiscController@index');
    $router->get('/user-rent-all', 'UserRentCompactDiscController@show_all_data');
    $router->post('/rent', 'UserRentCompactDiscController@rent');
    $router->post('/return', 'UserRentCompactDiscController@return');
    
    // AuthenticationController
    $router->post('/register', 'AuthController@register');
    $router->post('/login', 'AuthController@login');
 });
 

