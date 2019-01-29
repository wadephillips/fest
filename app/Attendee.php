<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{

  public function event()
  {
    return $this->hasOne('App\Event');
  }

  public function payment()
  {
    $this->hasOne('App\Payment');
  }
}
