<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{

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
