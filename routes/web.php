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

use App\Attendee;
use App\Event;
use App\Mail\RegistrationSuccessful;
use App\Payment;
use Illuminate\Support\Facades\Mail;

//Route::get('mailable/{id?}', function ($id = '17dcd8a0-3c68-11e9-9bc5-6d532e289ce0') {
//
//  $payment = Payment::find($id);
//  $payment->load('payer');
//  $payment_id = $payment->id;
//  $event_id = $payment->event_id;
//  $event = Event::find($event_id);
//  $attendees = Attendee::where('payment_id', $payment_id)->get();
//  Mail::to($attendees[0]->email)->send(new RegistrationSuccessful($attendees, $payment, $event));
//  return new RegistrationSuccessful($attendees, $payment, $event);
//});

Route::get('/', 'EventController@index');

Route::get('/events', 'EventController@index');
Route::get('/events/{event}', 'EventController@show');
Route::get('/events/{event}/register', 'EventRegisterController@show');
Route::get('/events/{event}/registered/{payment}', 'EventRegisterController@registered' )->name('registered');
Route::get('events/{event}/presenter/{code}', 'EventRegisterController@showPresenter');

Route::post('/events/{event}/register', 'EventRegisterController@register');





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

});
