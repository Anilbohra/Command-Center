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
Route::get('input-db',function(){
    return view('input-db');
});
Route::get('act',function(){
    return view('act');
});

Route::post('clone','CloneController@clone');
Route::post('compare','CloneController@compare');
Route::post('log','CloneController@get');
Route::post('import','CloneController@import_pegawai_to_db');
Route::post('kartu','CloneController@import_kartu_to_db');
Route::post('input-mesin','CloneController@input_to_mesin');
Route::post('input-db','CloneController@input_to_db');
Route::post('act','CloneController@act');
Auth::routes();