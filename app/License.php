<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    protected $fillable = ['country', 'state', 'number'];

    public function attendee()
    {
        return $this->belongsTo(Attendee::class);
    }
}
