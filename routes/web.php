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

Route::view('/', 'welcome');

Route::get('clone',function(){
    return view('clone');
});
Route::get('compare',function(){
    return view('compare');
});
Route::get('log',function(){
    return view('attLog');
});
Route::get('import',function(){
    return view('import');
});
Route::get('kartu',function(){
    return view('kartu');
});
Route::get('input-mesin',function(){
    return view('input-mesin');
});

Route::post('clone','MesinController@clone');
Route::post('compare','MesinController@compare');
Route::post('clear-mesin','MesinController@clearUser');
Route::post('hapus-manual','MesinController@deleteUser');
Route::post('tambah-manual','MesinController@addUser');
Route::post('log','MesinController@getLogKehadiran');
Route::post('import','MesinController@import_pegawai_to_db');
Route::post('kartu','MesinController@import_kartu_to_db');
Auth::routes();