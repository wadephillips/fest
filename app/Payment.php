<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
  use Uuids;

  /**
   * Indicates if the IDs are auto-incrementing.
   *
   * @var bool
   */
  public $incrementing = false;

  protected $fillable = [
      'amount',
      'processor_invoice_id',
      'processor_transaction_id',
      'processor',
      'event_id',
      'payer_id',
      'status',
      'token',
      'address',
      'address_2',
      'suite',
      'city',
      'state',
      'postal',
      'country',

  ];

  public function payer()
  {
    return $this->belongsTo('App\Attendee', 'payer_id', 'id');
  }

  public function paidFor()
  {
    return $this->hasMany('App\Attendee');
  }
}
