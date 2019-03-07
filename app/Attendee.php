<?php

namespace App;

use function array_merge;
use Illuminate\Database\Eloquent\Model;
use function var_dump;

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
    return $this->belongsTo(Event::class);
  }

  public function payment()
  {
    return $this->belongsTo(Payment::class);
  }

  public function licenses()
  {
    return $this->hasMany(License::class);
  }

  public function getDescriptionsAttribute()
  {
    $mods =
    $descriptions = [];
    foreach ( $this->modifiers as $key => $modifier ) {
      foreach ($modifier as $element) {
        $descriptions[] = $element['description'];
      }
    }
    return $descriptions;
  }
}
