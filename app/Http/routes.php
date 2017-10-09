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

Route::get('/admin/categories', 'CategoriesController@index')->name('admin.categories.index');
Route::get('/admin/categories/create', 'CategoriesController@create')->name('admin.categories.create');
Route::post('/admin/categories/store', 'CategoriesController@store')->name('admin.categories.store');
Route::get('/admin/categories/edit/{id}', 'CategoriesController@edit')->name('admin.categories.edit');
Route::post('/admin/categories/update/{id}', 'CategoriesController@update')->name('admin.categories.update');

Route::get('/admin/products', 'ProductsController@index')->name('admin.products.index');
Route::get('/admin/products/create', 'ProductsController@create')->name('admin.products.create');
Route::post('/admin/products/store', 'ProductsController@store')->name('admin.products.store');
Route::get('/admin/products/edit/{id}', 'ProductsController@edit')->name('admin.products.edit');
Route::post('/admin/products/update/{id}', 'ProductsController@update')->name('admin.products.update');
Route::get('/admin/products/destroy/{id}', 'ProductsController@destroy')->name('admin.products.destroy');