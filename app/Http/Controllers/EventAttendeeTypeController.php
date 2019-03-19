<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use function response;

class EventAttendeeTypeController extends Controller
{
  public function show(Event $event, $response_type)
  {
    //todo: resume select the appropriate attendees for the event and who have the appropriate registrations.  Write a test.
    return response('It works', 200);
  }
}
