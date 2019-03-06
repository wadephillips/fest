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

Route::get('mailable', function () {

  $payment = Payment::find('17dcd8a0-3c68-11e9-9bc5-6d532e289ce0');
  $payment_id = $payment->id;
  $event_id = $payment->event_id;
  $event = Event::find($event_id);
  $attendees = Attendee::where('payment_id', $payment_id)->get();
  return new RegistrationSuccessful($attendees, $payment, $event);
});

Route::get('/', 'EventController@index');

Route::get('/events', 'EventController@index');
Route::get('/events/{event}', 'EventController@show');
Route::get('/events/{event}/register', 'EventRegisterController@show');
Route::get('/events/{event}/registered/{payment}', 'EventRegisterController@registered' )->name('registered');

Route::post('/events/{event}/register', 'EventRegisterController@register');





Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});
