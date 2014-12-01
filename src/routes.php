<?php

Route::group(array(
    'prefix' => '/api',
), function() {

    /**
     * API v1
     */
    Route::group(array(
        'prefix'    => '/v1',
        // 'namespace' => 'Subbly\\Framework\\Api',
        'namespace' => 'Subbly\\CMS\\Controllers\\Api',
    ), function() {

        // AuthController
        Route::get('/auth/test-credentials', 'AuthController@testCredentials');
        Route::get('/auth/me', 'AuthController@testCurrentUser');

        // WelcomeController
        Route::get('/welcome', 'WelcomeController@index');

        // UsersController
        Route::get('/users/search', 'UsersController@search');
        Route::resource('users', 'UsersController', array('except' => array('create', 'edit')));

        // UserAddressesController
        Route::get('/users/{users}/user-addresses/search', 'UserAddressesController@search');
        Route::resource('users.addresses', 'UserAddressesController', array('except' => array('create', 'edit')));

        // ProductsController
        Route::get('/products/search', 'ProductsController@search');
        Route::resource('products', 'ProductsController', array('except' => array('create', 'edit')));

        // ProductCategoriesController
        Route::get('/products/{users}/categories/search', 'ProductCategoriesController@search');
        Route::resource('products.categories', 'ProductCategoriesController', array('except' => array('create', 'edit')));

        // ProductImagesController
        Route::get('/products/{users}/images/search', 'ProductImagesController@search');
        Route::resource('products.images', 'ProductImagesController', array('except' => array('create', 'edit')));

        // OrdersController
        Route::get('/orders/search', 'OrdersController@search');
        Route::resource('orders', 'OrdersController', array('except' => array('create', 'edit')));

        // SettingsController
        Route::get('/settings', 'SettingsController@index');
        Route::match(array('PATCH', 'PUT'), '/settings', 'SettingsController@update');
    });

    // /**
    //  * API v2
    //  */
    // Route::group(array(
    //     'prefix'    => '/v2',
    //     'namespace' => 'Subbly\\Framework\\Api\\V2',
    // ), function() {
    //
    //     // WelcomeController
    //     Route::get('/welcome', 'WelcomeController@index');
    // });

});
