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
Route::get('comments/{id}','API\KomentarController@all');

Route::middleware('auth:api','throttle:200,5')->group(function(){

    Route::resource('users','API\UsersController');
    Route::resource('otoritas','API\OtoritasController');
    Route::resource('produks','API\ProdukController');
    Route::post('produks/{id}','API\ProdukController@update');
    Route::resource('keranjangs','API\KeranjangBelanjaController');
	Route::get('lokasi/provinsi', 'API\LokasiController@provinsi');
	Route::get('lokasi/pilih-wilayah/{id}/{type}', 'API\LokasiController@pilih_wilayah');
    Route::resource('pesanans','API\PesanansController');
    Route::post('pesanans/filter','API\PesanansController@filter');
    Route::get('banks/all','API\BanksController@all');
    Route::resource('banks','API\BanksController');
    Route::resource('detail-pesanans','API\DetailPesanansController');
    Route::get('pesanan-saya','API\PesananSayaController@index');
    Route::post('pesanan-saya/upload-bukti-bayar/{id}','API\PesananSayaController@uploadBuktiPembayaran');
    Route::post('profil/ubah-password','API\ProfilController@ubahPassword');
    Route::resource('comments','API\KomentarController');

});
