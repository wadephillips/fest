<?php

namespace App\Http\Controllers\Admin;

use App\Event;
use function compact;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use function print_r;
use function response;

class DashboardController extends Controller
{
  public function show(Request $request)
  {
      //what do we want to display -
    $events = Event::where('active', true)
        ->with('attendees')
        ->get();

    foreach ($events as $event){
      $event->setTotalRegistrationTypes();
    }
//      $event->push('totalTypes', $types);
//    dd($events);

    // table with the registration types listed and the count for each one
    // count of attendees

    // count of attendees by registration type
    // count of food options
    // count of attendees with other_food
    //count of attendees with special requests
    // set up queries for them
    // cache the query responses

//    return response('the dashboard',200);
        return view('admin.dashboard', compact('events'));
  }
}
