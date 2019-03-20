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

//  public function index(Request $request, Event $event, $response_type)
//  {
//    // GET THE SLUG, ex. 'posts', 'pages', etc.
//    $slug = $this->getSlug($request);
//
//    // GET THE DataType based on the slug
//    $dataType = Voyager::model('DataType')->where('slug', '=', $slug)->first();
//
//    // Check permission
//    $this->authorize('browse', app($dataType->model_name));
//
//    $getter = $dataType->server_side ? 'paginate' : 'get';
//
//    $search = (object) ['value' => $request->get('s'), 'key' => $request->get('key'), 'filter' => $request->get('filter')];
//    $searchable = $dataType->server_side ? array_keys(SchemaManager::describeTable(app($dataType->model_name)->getTable())->toArray()) : '';
//    $orderBy = $request->get('order_by', $dataType->order_column);
//    $sortOrder = $request->get('sort_order', null);
//    $usesSoftDeletes = false;
//    $showSoftDeleted = false;
//    $orderColumn = [];
//    if ($orderBy) {
//      $index = $dataType->browseRows->where('field', $orderBy)->keys()->first() + 1;
//      $orderColumn = [[$index, 'desc']];
//      if (!$sortOrder && isset($dataType->order_direction)) {
//        $sortOrder = $dataType->order_direction;
//        $orderColumn = [[$index, $dataType->order_direction]];
//      } else {
//        $orderColumn = [[$index, 'desc']];
//      }
//    }
//
//    // Next Get or Paginate the actual content from the MODEL that corresponds to the slug DataType
//    if (strlen($dataType->model_name) != 0) {
//      $model = app($dataType->model_name);
//
//      if ($dataType->scope && $dataType->scope != '' && method_exists($model, 'scope'.ucfirst($dataType->scope))) {
//        $query = $model->{$dataType->scope}();
//      } else {
//        $query = $model::select('*');
//      }
//
//      // Use withTrashed() if model uses SoftDeletes and if toggle is selected
//      if ($model && in_array(SoftDeletes::class, class_uses($model)) && app('VoyagerAuth')->user()->can('delete', app($dataType->model_name))) {
//        $usesSoftDeletes = true;
//
//        if ($request->get('showSoftDeleted')) {
//          $showSoftDeleted = true;
//          $query = $query->withTrashed();
//        }
//      }
//
//      // If a column has a relationship associated with it, we do not want to show that field
//      $this->removeRelationshipField($dataType, 'browse');
//
//      if ($search->value != '' && $search->key && $search->filter) {
//        $search_filter = ($search->filter == 'equals') ? '=' : 'LIKE';
//        $search_value = ($search->filter == 'equals') ? $search->value : '%'.$search->value.'%';
//        $query->where($search->key, $search_filter, $search_value);
//      }
//
//      if ($orderBy && in_array($orderBy, $dataType->fields())) {
//        $querySortOrder = (!empty($sortOrder)) ? $sortOrder : 'desc';
//        $dataTypeContent = call_user_func([
//            $query->orderBy($orderBy, $querySortOrder),
//            $getter,
//        ]);
//      } elseif ($model->timestamps) {
//        $dataTypeContent = call_user_func([$query->latest($model::CREATED_AT), $getter]);
//      } else {
//        $dataTypeContent = call_user_func([$query->orderBy($model->getKeyName(), 'DESC'), $getter]);
//      }
//
//      // Replace relationships' keys for labels and create READ links if a slug is provided.
//      $dataTypeContent = $this->resolveRelations($dataTypeContent, $dataType);
//    } else {
//      // If Model doesn't exist, get data from table name
//      $dataTypeContent = call_user_func([DB::table($dataType->name), $getter]);
//      $model = false;
//    }
//
//    // Check if BREAD is Translatable
//    if (($isModelTranslatable = is_bread_translatable($model))) {
//      $dataTypeContent->load('translations');
//    }
//
//    // Check if server side pagination is enabled
//    $isServerSide = isset($dataType->server_side) && $dataType->server_side;
//
//    // Check if a default search key is set
//    $defaultSearchKey = $dataType->default_search_key ?? null;
//
//    $view = 'voyager::bread.browse';
//
//    if (view()->exists("voyager::$slug.browse")) {
//      $view = "voyager::$slug.browse";
//    }
//
//    //todo: can we massage this into an eloquent collection
//    $dataTypeContent = collect(DB::select(DB::raw(
//        "SELECT a.*
//                FROM attendees a, json_each(modifiers->'payment') b
//                WHERE a.event_id = ?
//                AND b.key = ?"
//    ), [ $event->id, $response_type ]));
//
////    dd(get_class($dataTypeContent));
//    return Voyager::view($view, compact(
//        'dataType',
//        'dataTypeContent',
//        'isModelTranslatable',
//        'search',
//        'orderBy',
//        'orderColumn',
//        'sortOrder',
//        'searchable',
//        'isServerSide',
//        'defaultSearchKey',
//        'usesSoftDeletes',
//        'showSoftDeleted'
//    ));
//  }

}
