<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  public function payer()
  {
    return $this->hasOne('App\Attendee');
  }

  public function paidFor()
  {
    return $this->hasMany('App\Attendee');
  }
}
