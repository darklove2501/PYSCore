<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'MainController@index');

Route::post('user/delete/{id}', 'UserController@delete');
Route::get('user/getIndexTemplate', 'UserController@getIndexTemplate');
Route::get('user/getAllUser', 'UserController@getAllUser');
Route::post('user/postNew', 'UserController@postNew');
Route::put('user/update/{id}', 'UserController@update');
Route::put('user/updatePassword/{id}', 'UserController@updatePassword');
Route::get('user/role/{id}', 'UserController@getUserRole');
Route::post('user/{id}/updateRole', 'UserController@updateRole');
Route::post('user/search', 'UserController@search');
Route::get('user', 'MainController@index');

Route::get('tour/tourTemplate', 'TourController@tourTemplate');
Route::get('tour/indexApi', 'TourController@indexApi');
Route::post('tour/search', 'TourController@search');
Route::resource('tour', 'TourController');

Route::get('booking/bookingTemplate', 'BookingController@bookingTemplate');
Route::get('booking/indexApi', 'BookingController@indexApi');
Route::get('booking/tour/{id}', 'BookingController@index');
Route::post('booking/getByTour', 'BookingController@getByTour');
Route::post('booking/searchApi', 'BookingController@searchApi');
Route::resource('booking', 'BookingController');

Route::get('role/getAll', 'RoleController@getAll');

Route::get('auth/login', 'Auth\AuthController@getLogin');
Route::post('auth/login', 'Auth\AuthController@postLogin');
Route::get('auth/logout', 'Auth\AuthController@getLogout');

Route::get('angularValidationMessages', 'MainController@angularValidationMessages');