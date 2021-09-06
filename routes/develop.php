<?php

/*
 * Send an example event registration email
 */
Route::get('mailable/{id?}', function ($id = '17dcd8a0-3c68-11e9-9bc5-6d532e289ce0') {

  $payment = Payment::find($id);
  $payment->load('payer');
  $payment_id = $payment->id;
  $event_id = $payment->event_id;
  $event = Event::find($event_id);
  $attendees = Attendee::where('payment_id', $payment_id)->get();
  Mail::to($attendees[0]->email)->send(new RegistrationSuccessful($attendees, $payment, $event));
  return new RegistrationSuccessful($attendees, $payment, $event);
});

/*
 * Send a test of the Registration Error Email
 */
Route::get('registration_error/', function() {
  Mail::to('techsupport@pocacoop.com')->send(new RegistrationError([ 'things' => 'that went wrong',], 'test route'));
});
