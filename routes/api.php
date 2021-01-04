<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('/cart', 'CartController@index');
Route::post('/cart', 'CartController@store');
Route::delete('/cart/remove_all_items/{id}', 'CartController@delete');
Route::get('/cart/{id}', 'CartController@show');
Route::patch('/cart/{id}', 'CartController@update');
Route::delete('/cart/{id}', 'CartController@destroy');

Route::get('/customers', 'CustomerController@index');
Route::post('/customer', 'CustomerController@store');
Route::delete('/customer/delete_all', 'CustomerController@delete');
Route::get('/customer/{id}', 'CustomerController@show');
Route::patch('/customer/{id}', 'CustomerController@update');
Route::delete('/customer/{id}', 'CustomerController@destroy');

Route::get('/orders', 'OrderController@index');
Route::post('/order', 'OrderController@store');
Route::get('/order/{id}', 'OrderController@show');
Route::patch('/order/{id}', 'OrderController@update');

Route::get('/product', 'ProductController@index');
Route::post('/product', 'ProductController@store');
Route::delete('/product/delete_all', 'ProductController@delete');
Route::get('/product/{id}', 'ProductController@show');
Route::patch('/product/{id}', 'ProductController@update');
Route::delete('/product/{id}', 'ProductController@destroy');

Route::get('/user', 'UserController@index');
Route::post('/user', 'UserController@store');
Route::delete('/user/remove_all_user', 'UserController@delete');
Route::get('/user/{id}', 'UserController@show');
Route::patch('/user/{id}', 'UserController@update');
Route::delete('/user/{id}', 'UserController@destroy');

Route::post('/login', 'LoginController@adminLogin');
Route::get('/logout', 'LoginController@logout');