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

Route::get('/', ['as' => 'home', 'uses' => 'HomeController@index']);

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::match(array('GET', 'POST'), '/login', 'LoginController@login');
Route::match(array('GET', 'POST'), '/logout', 'LoginController@logout');

Route::group(['prefix' => 'admin', 'middleware' => 'auth.checkrole', 'as' => 'admin.'], function() {

	Route::get('categories', ['as' => 'categories.index', 'uses' => 'CategoriesController@index']);
	Route::get('categories/edit/{id}', ['as' => 'categories.edit','uses' => 'CategoriesController@edit']);
	Route::get('categories/create', ['as' => 'categories.create','uses' => 'CategoriesController@create']);
	Route::post('categories/store', ['as' => 'categories.store','uses' => 'CategoriesController@store']);
	Route::post('categories/update/{id}', ['as' => 'categories.update','uses' => 'CategoriesController@update']);
	Route::get('categories/delete/{id}', ['as' => 'categories.delete','uses' => 'CategoriesController@destroy']);

	Route::get('products', ['as' => 'products.index', 'uses' => 'ProductsController@index']);
	Route::get('products/edit/{id}', ['as' => 'products.edit','uses' => 'ProductsController@edit']);
	Route::get('products/create', ['as' => 'products.create','uses' => 'ProductsController@create']);
	Route::post('products/store', ['as' => 'products.store','uses' => 'ProductsController@store']);
	Route::post('products/update/{id}', ['as' => 'products.update','uses' => 'ProductsController@update']);
	Route::get('products/delete/{id}', ['as' => 'products.delete','uses' => 'ProductsController@destroy']);

	Route::get('products/json/{id}', ['as' => 'products.json','uses' => 'ProductsController@json']);

	Route::get('clients', ['as' => 'clients.index', 'uses' => 'ClientsController@index']);
	Route::get('clients/edit/{id}', ['as' => 'clients.edit','uses' => 'ClientsController@edit']);
	Route::get('clients/create', ['as' => 'clients.create','uses' => 'ClientsController@create']);
	Route::post('clients/store', ['as' => 'clients.store','uses' => 'ClientsController@store']);
	Route::post('clients/update/{id}', ['as' => 'clients.update','uses' => 'ClientsController@update']);
	Route::get('clients/delete/{id}', ['as' => 'clients.delete','uses' => 'ClientsController@destroy']);

	Route::get('orders', ['as' => 'orders.index', 'uses' => 'OrdersController@index']);
	Route::get('orders/edit/{id}', ['as' => 'orders.edit','uses' => 'OrdersController@edit']);
	Route::get('orders/create', ['as' => 'orders.create','uses' => 'OrdersController@create']);
	Route::post('orders/store', ['as' => 'orders.store','uses' => 'OrdersController@store']);
	Route::post('orders/update/{id}', ['as' => 'orders.update','uses' => 'OrdersController@update']);
	Route::get('orders/delete/{id}', ['as' => 'orders.delete','uses' => 'OrdersController@destroy']);

});

