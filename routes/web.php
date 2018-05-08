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

Route::group(['middleware' => ['api', 'cors'], 'prefix' => 'api'], function(){
    Route::post('driver_login', 'DriverAuthController@login');
    Route::post('bus/{id}/updateLocation', 'BusController@updateLocation');
    Route::post('bus/{id}/update_next_stop', 'BusController@update_next_stop');
    Route::get('driver_register', 'DriverAuthController@register');
    Route::get('announcement/getAnnouncement', 'AnnouncementController@getAnnouncementData');
    Route::get('bus/getBusTrackingData', 'BusController@getBusTrackingData');
    Route::get('bus/{id}/getOperatingInfo', 'BusController@getOperatingInfo');
    Route::get('bus/getETA/origin={origin}/destination={destination}', 'BusController@getETA');
    Route::get('bus_stop/getBusStop', 'BusStopController@getBusStopData');
    Route::get('driver/{id}/getAssignedInfo', 'DriverController@getAssignedInfo');
    Route::get('route/getRoute', 'RouteController@getRouteData');
    Route::get('route/{id}/getRelevantBuses', 'RouteController@getRelevantBuses');
    Route::post('report/store', 'ReportController@store');
    Route::post('reservation/store', 'ReservationController@store');
    Route::get('reservation/getNewID', 'ReservationController@getNewID');
    Route::get('reservation/getReservationData', 'ReservationController@getReservationData');
});

Route::group(['middleware' => ['web','auth']], function () {

    Route::get('/', function(){
        return redirect('home');
    });

    Route::get('home', 'DashboardController@index')->name('home');
    Route::get('home/dashboard.data', 'DashboardController@dashboard')->name('dashboard.data');
    Route::get('home/{id}/deleteOperation', 'DashboardController@deleteOperation');
    Route::post('home/setupOperation', 'DashboardController@setupOperation')->name('setupOperation');

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
    Route::get('bus/datatables.data', 'BusController@anyData')->name('bus_datatables.data');
    Route::get('bus/create', 'BusController@create')->name('createBus');
    Route::post('bus/{id}/store', 'BusController@store')->name('storeBus');
    Route::get('bus/{id}/edit', 'BusController@edit');
    Route::post('bus/{id}/update', 'BusController@update')->name('updateBus');
    Route::get('bus/{id}/delete', 'BusController@destroy');

    //Driver
    Route::get('driver', 'DriverController@index')->name('driver');
    Route::get('driver/datatables.data', 'DriverController@anyData')->name('driver_datatables.data');
    Route::get('driver/create', 'DriverController@create')->name('createDriver');
    Route::post('driver/{id}/store', 'DriverController@store')->name('storeDriver');
    Route::get('driver/{id}/edit', 'DriverController@edit');
    Route::post('driver/{id}/update', 'DriverController@update')->name('updateDriver');
    Route::get('driver/{id}/delete', 'DriverController@destroy');

    //Bus Stop
    Route::get('bus_stop', 'BusStopController@index')->name('bus_stop');
    Route::get('bus_stop/datatables.data', 'BusStopController@anyData')->name('bus_stop_datatables.data');
    Route::get('bus_stop/create', 'BusStopController@create')->name('createBusStop');
    Route::post('bus_stop/{id}/store', 'BusStopController@store')->name('storeBusStop');
    Route::get('bus_stop/{id}/edit', 'BusStopController@edit');
    Route::post('bus_stop/{id}/update', 'BusStopController@update')->name('updateBusStop');
    Route::get('bus_stop/{id}/delete', 'BusStopController@destroy');

    //Bus Reservation
    Route::get('reservation', 'ReservationController@index')->name('reservation');
    Route::get('reservation/datatables.data', 'ReservationController@anyData')->name('reservation_datatables.data');
    Route::get('reservation/{id}/view', 'ReservationController@view')->name('viewReservation');
    // Route::get('reservation/{id}/edit', 'ReservationController@edit');
    // Route::post('reservation/{id}/update', 'ReservationController@update')->name('updateReservation');
    Route::get('reservation/{id}/delete', 'ReservationController@destroy');

    //Report
    Route::get('report', 'ReportController@index')->name('report');
    Route::get('report/datatables.data', 'ReportController@anyData')->name('report_datatables.data');
    Route::get('report/{id}/view', 'ReportController@view');
    Route::get('report/{id}/resolve', 'ReportController@resolve')->name('resolveReport');
    Route::get('report/{id}/delete', 'ReportController@destroy');
});