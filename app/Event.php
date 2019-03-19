<?php

namespace App;

use function array_combine;
use function array_pluck;
use function dd;
use Hashids\Hashids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use function secure_url;
use function var_dump;

class Event extends Model
{
  private $totalRegistrationTypes;

  /**
   * Get the route key for the model.
   *
   * @return string
   */
  public function getRouteKeyName()
  {
    return 'slug';
  }

  /**
   * The attributes that should be mutated to dates.
   *
   * @var array
   */
  protected $dates = [
      'start',
      'end'
  ];

  public function attendees()
  {
    return $this->hasMany('App\Attendee');
  }

  public function breakouts()
  {
    return $this->hasMany('App\Breakout');
  }

  public function fees()
  {
    return $this->hasMany('App\EventFee');
  }

  public function setTotalRegistrationTypes()
  {
    $result = DB::select(DB::raw(
        "SELECT b.key, count(b.key) 
              FROM attendees a, json_each(a.modifiers->'payment') b
              WHERE a.event_id = ?
                    AND b.key NOT IN ('poca_tech_donation','linens')
              GROUP BY b.key ORDER BY b.key"), [$this->id]);
    $keys = array_pluck($result, 'key');
    $values = array_pluck($result, 'count');

    $this->totalRegistrationTypes = array_combine($keys, $values);
  }

  /**
   * @return mixed
   */
  public function getTotalRegistrationTypes()
  {
    return $this->totalRegistrationTypes;
  }


  public function getAttendeeCountAttribute()
  {
    if ( !$this->relationLoaded('attendees') ) {
      $this->load('attendees');
    }
    return $this->attendees->count();
  }

  public function getDatesAttribute()
  {
    $dates = $this->start->format('F jS, Y');
    if ( $this->end->diffInDays($this->start) >= 1 ) {
      $dates .= ' - ' . $this->end->format('F jS, Y');
    }
//    else {
//      $dates .= $this->end->format(');
//    }
    return $dates;
  }

  public function getPresentersAttribute()
  {
    return $this->breakouts
        ->pluck('presenters')
        ->flatten(1)
        ->unique('id')
        ->sortBy('id');
  }

  public function getPresenterUrlAttribute()
  {
    $hashId = new Hashids(env('HASH_ID_SALT'), 8);
    $code = $hashId->encode($this->id);
//    dd(secure_url('/events/' . $this->slug . '/presenter/' . $code));
    return secure_url('/events/' . $this->slug . '/presenter/' . $code);
  }

  public function getRegistrationTotalsAttribute()
  {
    //todo resume: play with raw queries from DataGrip in tinker.  Switch dev db to pgsql
    $attendee_aggragates = DB::raw('');
  }


}
