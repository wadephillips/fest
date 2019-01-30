<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attendee extends Model
{

  /**
   * The attributes that should be cast to native types.
   *
   * @var array
   */
  protected $casts = [
      'modifiers' => 'array',
  ];

  public function event()
  {
    return $this->hasOne('App\Event');
  }

  public function payment()
  {
    $this->hasOne('App\Payment');
  }
}
