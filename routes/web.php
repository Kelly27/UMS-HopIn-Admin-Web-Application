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


Auth::routes();

Route::group(['middleware' => ['web','auth']], function () {

    Route::get('/', function(){
        return redirect('home');
    });

    Route::get('home', 'HomeController@index')->name('home');

    Route::get('announcement', 'AnnouncementController@index')->name('announcement');

    Route::get('route', 'RouteController@index')->name('route');
    Route::get('route/create', 'RouteController@create')->name('createRoute');
    Route::post('route/store', 'RouteController@store')->name('storeRoute');
    Route::get('route/{id}/edit', 'RouteController@edit');
    Route::get('route/{id}/delete', 'RouteController@destroy');
    Route::get('route/datatables.data', 'RouteController@anyData')->name('route_datatables.data');

});