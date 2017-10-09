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