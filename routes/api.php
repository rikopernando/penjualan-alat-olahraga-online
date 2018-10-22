<?php

use Illuminate\Http\Request;

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

Route::get('produks/all','API\ProdukController@all');

Route::middleware('auth:api','throttle:100,10')->group(function(){

    Route::resource('users','API\UsersController');
    Route::resource('otoritas','API\OtoritasController');
    Route::resource('produks','API\ProdukController');
    Route::post('produks/{id}','API\ProdukController@update');
    Route::resource('keranjangs','API\KeranjangBelanjaController');
	Route::get('lokasi/provinsi', 'API\LokasiController@provinsi');
	Route::get('lokasi/pilih-wilayah/{id}/{type}', 'API\LokasiController@pilih_wilayah');
    Route::resource('pesanans','API\PesanansController');
    Route::resource('banks','API\BanksController');

});
