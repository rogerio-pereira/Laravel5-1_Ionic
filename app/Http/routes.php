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

//Admin
Route::group(['prefix' => '/admin', 'middleware' => 'auth.checkrole',  'as' => 'admin.'], function() {
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
});