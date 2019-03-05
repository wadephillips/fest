<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

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

  public function getDatesAttribute()
  {
    $dates = $this->start->format('F jS, Y');
    if($this->end->diffInDays($this->start) >= 1){
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


}