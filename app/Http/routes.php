<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', function () {
    return view('welcome');
});

//Admin
Route::group(['prefix' => '/admin', 'middleware' => 'auth.checkrole:admin',  'as' => 'admin.'], function() {
    //Categorias
    Route::group(['prefix' => '/categories', 'as' => 'categories.'], function() {
        Route::get('/', 'CategoriesController@index')->name('index');
        Route::get('/create', 'CategoriesController@create')->name('create');
        Route::post('/store', 'CategoriesController@store')->name('store');
        Route::get('/edit/{id}', 'CategoriesController@edit')->name('edit');
        Route::post('/update/{id}', 'CategoriesController@update')->name('update');
    });

    //Produtos
    Route::group(['prefix' => '/products', 'as' => 'products.'], function() {
        Route::get('/', 'ProductsController@index')->name('index');
        Route::get('/create', 'ProductsController@create')->name('create');
        Route::post('/store', 'ProductsController@store')->name('store');
        Route::get('/edit/{id}', 'ProductsController@edit')->name('edit');
        Route::post('/update/{id}', 'ProductsController@update')->name('update');
        Route::get('/destroy/{id}', 'ProductsController@destroy')->name('destroy');
    });

    //Clientes
    Route::group(['prefix' => '/clients', 'as' => 'clients.'], function() {
        Route::get('/', 'ClientsController@index')->name('index');
        Route::get('/create', 'ClientsController@create')->name('create');
        Route::post('/store', 'ClientsController@store')->name('store');
        Route::get('/edit/{id}', 'ClientsController@edit')->name('edit');
        Route::post('/update/{id}', 'ClientsController@update')->name('update');
        Route::get('/destroy/{id}', 'ClientsController@destroy')->name('destroy');
    });

    //Orders
    Route::group(['prefix' => '/orders', 'as' => 'orders.'], function() {
        Route::get('/', 'OrdersController@index')->name('index');
        Route::get('/edit/{id}', 'OrdersController@edit')->name('edit');
        Route::post('/update/{id}', 'OrdersController@update')->name('update');
        Route::get('/destroy/{id}', 'OrdersController@destroy')->name('destroy');
    });

    //Cupoms
    Route::group(['prefix' => '/cupoms', 'as' => 'cupoms.'], function() {
        Route::get('/', 'CupomsController@index')->name('index');
        Route::get('/create', 'CupomsController@create')->name('create');
        Route::post('/store', 'CupomsController@store')->name('store');
        Route::get('/edit/{id}', 'CupomsController@edit')->name('edit');
        Route::post('/update/{id}', 'CupomsController@update')->name('update');
        Route::get('/destroy/{id}', 'CupomsController@destroy')->name('destroy');
    });
});

Route::group(['prefix' => '/customer', 'middleware' => 'auth.checkrole:client', 'as' => 'customer.'], function() {
    //Orders
    Route::group(['prefix' => '/orders', 'as' => 'orders.'], function() {
        Route::get('/', 'CheckoutController@index')->name('index');
        Route::get('create', 'CheckoutController@create')->name('create');
        Route::post('/store', 'CheckoutController@store')->name('store');
    });
});


//API
Route::post('oauth/access_token', function() {
    return Response::json(Authorizer::issueAccessToken());
});

Route::group([
    'prefix' => 'api', 
    'middleware' => 'oauth', 
    'as' => 'api.', 
    'namespace' => 'Api'
], function() {

    //Client 
    Route::group([
        'prefix' => 'client', 
        'middleware' => 'oauth.checkrole:client', 
        'as' => 'client.', 
        'namespace' => 'Client'
    ], function() {
        Route::resource('order', 
            'ClientCheckoutController', 
            ['except' => ['create', 'edit', 'destroy']]
        ); 
    });


    Route::group(['prefix' => 'deliveryman',  'middleware' => 'oauth.checkrole:deliveryman', 'as' => 'deliveryman.'], function() {
        
        Route::get('pedidos', function(){
            return [
                'id' => 1,
                'client' => 'Rogerio Pereira Entregador',
                'total' => 10
            ];
        });
    });
});