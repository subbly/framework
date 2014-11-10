<?php

Route::group(array(
    'prefix'    => '/api/v1',
    'namespace' => 'Subbly\\Framework\\Api',
), function() {

    // AuthController
    Route::get('/auth/test-credentials', 'AuthController@testCredentials');
    Route::get('/auth/me', 'AuthController@testCurrentUser');

    // WelcomeController
    Route::get('/welcome', 'WelcomeController@index');

    // UsersController
    Route::get('/users/search', 'UsersController@search');
    Route::resource('/users', 'UsersController', array('except' => array('create', 'edit')));

    // ProductsController
    Route::get('/products/search', 'ProductsController@search');
    Route::resource('/products', 'ProductsController', array('except' => array('create', 'edit')));

    // OrdersController
    Route::get('/orders/search', 'OrdersController@search');
    Route::resource('/orders', 'OrdersController', array('except' => array('create', 'edit')));

    // SettingsController
    Route::get('/settings', 'SettingsController@index');
    Route::match(array('PATCH', 'PUT'), '/settings/{setting_key}', 'SettingsController@update');
});
