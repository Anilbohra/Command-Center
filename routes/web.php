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

Route::prefix('mesin')->group(function () {
    Route::middleware(['ajax'])->group(function(){
        Route::get('manage','MesinController@manageForm');
        Route::get('clone','MesinController@cloneForm');
        Route::get('compare','MesinController@compareForm');
        Route::get('clear-personil','MesinController@clearUserForm');
        Route::get('hapus-manual','MesinController@deleteUserForm');
        Route::get('tambah-manual','MesinController@addUserForm');
        Route::get('clear-log','MesinController@clearLogKehadiranForm');
        Route::get('log','MesinController@getLogKehadiranForm');
    });
    
    Route::post('clone','MesinController@clone');
    Route::post('compare','MesinController@compare');
    Route::post('clear-mesin','MesinController@clearUser');
    Route::post('hapus-manual','MesinController@deleteUser');
    Route::post('tambah-manual','MesinController@addUser');
    Route::post('clear-log','MesinController@clearLogKehadiran');
    Route::post('log','MesinController@getLogKehadiran');
    
    Route::post('tambah-mesin','MesinController@tambahMesin');
    Route::post('hapus-mesin','MesinController@hapusMesin');
    Route::post('edit-mesin','MesinController@editMesin');
});

Route::post('import','ImportController@import_pegawai_to_db');
Route::post('kartu','ImportController@import_kartu_to_db');

Auth::routes();