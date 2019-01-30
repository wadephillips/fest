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

Route::get('/events', 'EventController@index');
Route::get('/events/{event}', 'EventController@show');
Route::get('/events/{event}/register', 'EventRegisterController@show');
Route::get('/events/{event}/registered', 'EventRegisterController@registered' );




Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
