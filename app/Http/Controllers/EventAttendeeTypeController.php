<?php

namespace App\Http\Controllers;

use function compact;
use function dd;
use function get_class;
use function get_class_vars;
use function json_decode;
use TCG\Voyager\Http\Controllers\Controller;
use App\Attendee;
use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\SoftDeletes;
use TCG\Voyager\Database\Schema\SchemaManager;
use TCG\Voyager\Events\BreadDataAdded;
use TCG\Voyager\Events\BreadDataDeleted;
use TCG\Voyager\Events\BreadDataRestored;
use TCG\Voyager\Events\BreadDataUpdated;
use TCG\Voyager\Events\BreadImagesDeleted;
use TCG\Voyager\Facades\Voyager;
use TCG\Voyager\Http\Controllers\Traits\BreadRelationshipParser;
use function response;
use function view;

class EventAttendeeTypeController extends Controller
{
  use BreadRelationshipParser;

  public function show(Request $request, Event $event, $response_type)
  {
    $attendees = collect(DB::select(DB::raw(
        "SELECT a.*
                FROM attendees a, json_each(modifiers->'payment') b
                WHERE a.event_id = ?
                AND b.key = ?"
    ), [ $event->id, $response_type ]));

    $attendeeTypeDescription = ($attendees->isNotEmpty())
        ? json_decode($attendees[0]->modifiers, true)['payment'][$response_type]['description']
        : $response_type;


    return view('admin.event.attendees.type', compact('event', 'attendees', 'attendeeTypeDescription' ));
  }

  public function linens(Request $request, Event $event, $value, $description)
  {
    $attendees = collect(DB::select(DB::raw(
        "SELECT a.*
                FROM attendees a, json_each(modifiers->'payment') b
                WHERE a.event_id = ?
                AND b.key = ?
                AND b.value->>'description' = ?"
    ), [ $event->id, $value, $description ]));

    $attendeeTypeDescription = ($attendees->isNotEmpty())
        ? json_decode($attendees[0]->modifiers, true)['payment'][$value]['description']
        : $value;


    return view('admin.event.attendees.type', compact('event', 'attendees', 'attendeeTypeDescription' ));
  }

}
