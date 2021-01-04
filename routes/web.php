<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});


Route::post('/cart/{id}', 'CartController@store');
Route::patch('/cart/{id}', 'CartController@update');
Route::delete('/cart/{id}', 'CartController@destroy');
Route::delete('/cart/remove_all_items/{id}', 'CartController@delete');

Route::post('/customer', 'CustomerController@store');
Route::delete('/customer/delete_all', 'CustomerController@delete');
Route::patch('/customer/{id}', 'CustomerController@update');
Route::delete('/customer/{id}', 'CustomerController@destroy');

Route::post('/order', 'OrderController@store');
Route::patch('/order/{id}', 'OrderController@update');

Route::post('/product', 'ProductController@store');
Route::delete('/product/delete_all', 'ProductController@delete');
Route::patch('/product/{id}', 'ProductController@update');
Route::delete('/product/{id}', 'ProductController@destroy');

Route::delete('/user/remove_all_user', 'UserController@delete');
Route::post('/user', 'UserController@store');
Route::patch('/user/{id}', 'UserController@update');
Route::delete('/user/{id}', 'UserController@destroy');

Route::post('/login', 'LoginController@adminLogin');
Route::get('/logout', 'LoginController@logout');