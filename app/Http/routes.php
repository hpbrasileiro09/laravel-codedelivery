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

Route::get('/', function() {
	return view('welcome');
});

Route::get('/home', function() {
	return view('welcome');
});

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::post('oauth/access_token', function () {
	return Response::json(Authorizer::issueAccessToken());
});

Route::match(array('GET', 'POST'), '/login', 'LoginController@login');
Route::match(array('GET', 'POST'), '/logout', 'LoginController@logout');

Route::get('panel', ['as' => 'panel', 'uses' => 'HomeController@index']);

Route::group(['prefix' => 'admin', 'middleware' => 'auth.checkrole:admin', 'as' => 'admin.'], function() {

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
	Route::post('orders/update/{id}', ['as' => 'orders.update','uses' => 'OrdersController@update']);
	Route::post('orders/store', ['as' => 'orders.store','uses' => 'OrdersController@store']);
	Route::get('orders/delete/{id}', ['as' => 'orders.delete','uses' => 'OrdersController@destroy']);

	Route::get('cupoms', ['as' => 'cupoms.index', 'uses' => 'CupomsController@index']);
	Route::get('cupoms/{id}', ['as' => 'cupoms.edit','uses' => 'CupomsController@edit']);
	Route::post('cupoms/update/{id}', ['as' => 'cupoms.update','uses' => 'CupomsController@update']);
	Route::get('cupoms/create', ['as' => 'cupoms.create','uses' => 'CupomsController@create']);
	Route::post('cupoms/store', ['as' => 'cupoms.store','uses' => 'CupomsController@store']);
	Route::get('cupoms/delete/{id}', ['as' => 'cupoms.delete','uses' => 'CupomsController@destroy']);

});

Route::group(['prefix' => 'customer', 'middleware' => 'auth.checkrole:client', 'as' => 'customer.'], function() {

	Route::get('order', ['as' => 'order.index','uses' => 'CheckoutController@index']);
	Route::get('order/create', ['as' => 'order.create','uses' => 'CheckoutController@create']);
	Route::post('order/store', ['as' => 'order.store','uses' => 'CheckoutController@store']);

});

Route::group(['prefix' => 'api', 'middleware' => 'oauth', 'as' => 'api.'], function() {

	Route::get('pedidos', function() {
		return [
			'id' => 1,
			'client' => 'Luiz Carlos',		
			'total' => 10,
		];
	});

	Route::get('teste', function() {
		return [
			'message' => 'Isso Eh um Teste!',
		];
	});

});
