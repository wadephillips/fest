<?php

use App\Attendee;
use App\Event;
use App\Mail\RegistrationError;
use App\Mail\RegistrationSuccessful;
use App\Payment;
use Illuminate\Support\Facades\Mail;

/*
 * Primary Display Routes
 */
Route::get('/', 'EventController@index');

Route::get('/events', 'EventController@index');

Route::get('/events/{event}', 'EventController@show');

Route::get('/events/{event}/register', 'EventRegisterController@show');

Route::get('/events/{event}/registered/{payment}', 'EventRegisterController@registered')->name('registered');

Route::get('events/{event}/presenter/{code}', 'EventRegisterController@showPresenter');

/*
 * Admin Routes
 */
Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();

    Route::get('/', 'Admin\DashboardController@show')
        ->name('voyager.dashboard')
        ->middleware('admin.user');

    Route::get('/attendees/{event}/registration-type/{registration}', 'EventAttendeeTypeController@show')
        ->name('event.attendees.type')
        ->middleware('admin.user');

    Route::get('/attendees/{event}/donors/{type}', 'EventAttendeeTypeController@show')
        ->name('event.donors')
        ->middleware('admin.user');

    Route::get('/attendees/{event}/linens/{type}/{description}', 'EventAttendeeTypeController@linens')
        ->name('event.linens')
        ->middleware('admin.user');
});
