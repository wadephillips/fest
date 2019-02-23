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

  protected $fillable = [
      'event_id',
      'payment_id',
      'name',
      'email',
      'phone',
      'address',
      'address_2',
      'suite',
      'city',
      'state',
      'postal',
      'country',
      'emergency_contact_name',
      'emergency_contact_phone',
      'emergency_contact_relationship',
      'modifiers',
      'total',
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
