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

  public function attendees()
  {
    return $this->hasMany('App\Attendee');
  }

  public function breakouts()
  {
    return $this->hasMany('App\Breakout');
  }

  public function presenters()
  {
    return $this->hasManyThrough('App\Presenter', 'App\Breakout');
  }
}
