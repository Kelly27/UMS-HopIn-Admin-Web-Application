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

    //Route
    Route::get('route', 'RouteController@index')->name('route');
    Route::get('route/datatables.data', 'RouteController@anyData')->name('route_datatables.data');
    Route::get('route/create', 'RouteController@create')->name('createRoute');
    Route::post('route/{id}/store', 'RouteController@store')->name('storeRoute');
    Route::get('route/{id}/edit', 'RouteController@edit');
    Route::post('route/{id}/update', 'RouteController@update')->name('updateRoute');
    Route::get('route/{id}/delete', 'RouteController@destroy');

    //Announcement
    Route::get('announcement', 'AnnouncementController@index')->name('announcement');
    Route::get('annoucement/datatables.data', 'AnnouncementController@anyData')->name('announcement_datatables.data');
    Route::get('annoucement/create', 'AnnouncementController@create')->name('createAnnouncement');
    Route::post('annoucement/{id}/store', 'AnnouncementController@store')->name('storeAnnouncement');
    Route::get('announcement/{id}/edit', 'AnnouncementController@edit');
    Route::post('announcement/{id}/update', 'AnnouncementController@update')->name('updateAnnouncement');
    Route::get('announcement/{id}/delete', 'AnnouncementController@destroy');

    //Bus
    Route::get('bus', 'BusController@index')->name('bus');
    Route::get('bus/datatables.data', 'BusController@anyData')->name('bus_datatables.data');
    Route::get('bus/create', 'BusController@create')->name('createBus');
    Route::post('bus/{id}/store', 'BusController@store')->name('storeBus');
    Route::get('bus/{id}/edit', 'BusController@edit');
    Route::post('bus/{id}/update', 'BusController@update')->name('updateBus');
    Route::get('bus/{id}/delete', 'BusController@destroy');
});