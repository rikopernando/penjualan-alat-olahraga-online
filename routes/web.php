<?php

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

route::get('/auth', 'AuthController@auth');
route::get('pesanans-cetak-penjualan', 'API\PesanansController@cetak');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
