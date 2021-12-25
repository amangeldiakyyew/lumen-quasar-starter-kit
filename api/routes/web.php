<?php

/** @var \Laravel\Lumen\Routing\Router $router */

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api/v1', 'namespace' => 'Api\V1'], function () use ($router) {

    $router->post('init', 'InitController@index');

    $router->group(['prefix' => 'auth'], function () use ($router) {
        $router->post('register', 'AuthController@register');
        $router->post('login', 'AuthController@login');
        $router->post('logout', 'AuthController@logout');
        $router->post('check', 'AuthController@check');
    });

    $router->group(['prefix' => 'categories'], function () use ($router) {
        $router->get('/', 'CategoryController@index');
    });

    $router->group(['prefix' => 'profile', 'middleware' => 'auth:' . env('API_USER_AUTH_GUARD')], function () use ($router) {
        $router->get('/', 'ProfileController@index');
        $router->put('/', 'ProfileController@update');
    });
});

$router->group(['prefix' => 'api/admin', 'namespace' => 'Api\Admin'], function () use ($router) {

    $router->group(['prefix' => 'auth'], function () use ($router) {
        $router->post('login', 'AuthController@login');
        $router->post('logout', 'AuthController@logout');
        $router->post('check', 'AuthController@check');
        $router->group(['middleware' => 'auth:' . env('API_ADMIN_AUTH_GUARD')], function () use ($router) {
            $router->get('user', 'AuthController@me');
        });
    });

    $router->group(['middleware' => 'auth:' . env('API_ADMIN_AUTH_GUARD')], function () use ($router) {

        $router->post('upload', 'UploadController@upload');

        $router->group(['prefix' => 'admins'], function () use ($router) {
            $router->get('/', 'AdminController@index');
            $router->post('/', 'AdminController@store');
            $router->get('/{id}', 'AdminController@show');
            $router->put('/{id}', 'AdminController@update');
            $router->delete('/{id}', 'AdminController@delete');
        });

        $router->group(['prefix' => 'users'], function () use ($router) {
            $router->get('/', 'UserController@index');
            $router->post('/', 'UserController@store');
            $router->get('/{id}', 'UserController@show');
            $router->put('/{id}', 'UserController@update');
            $router->delete('/{id}', 'UserController@delete');
        });

        $router->group(['prefix' => 'categories'], function () use ($router) {
            $router->get('/autocomplete', 'CategoryController@autocomplete');
            $router->get('/', 'CategoryController@index');
            $router->post('/', 'CategoryController@store');
            $router->get('/{id}', 'CategoryController@show');
            $router->put('/{id}', 'CategoryController@update');
            $router->delete('/{id}', 'CategoryController@delete');
        });

        $router->group(['prefix' => 'information'], function () use ($router) {
            $router->get('/', 'InformationController@index');
            $router->post('/', 'InformationController@store');
            $router->get('/{id}', 'InformationController@show');
            $router->put('/{id}', 'InformationController@update');
            $router->delete('/{id}', 'InformationController@delete');
        });

        $router->group(['prefix' => 'settings'], function () use ($router) {
            $router->get('/', 'SettingController@index');
            $router->put('/', 'SettingController@update');
        });

        $router->group(['prefix' => 'countries'], function () use ($router) {
            $router->get('/', 'CountryController@index');
            $router->post('/', 'CountryController@store');
            $router->get('/{id}', 'CountryController@show');
            $router->put('/{id}', 'CountryController@update');
            $router->delete('/{id}', 'CountryController@delete');
        });

        $router->group(['prefix' => 'states'], function () use ($router) {
            $router->get('/', 'StateController@index');
            $router->post('/', 'StateController@store');
            $router->get('/{id}', 'StateController@show');
            $router->put('/{id}', 'StateController@update');
            $router->delete('/{id}', 'StateController@delete');
        });
    });

});


