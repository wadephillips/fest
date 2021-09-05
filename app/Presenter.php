<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presenter extends Model
{
    public function breakouts()
    {
        return $this->belongsToMany('App\Breakout')->using('App\BreakoutPresenter');
    }

    public function getEventsAttribute()
    {
        return $this->breakouts
        ->pluck('event')
        ->flatten(1)
        ->unique('id')
        ->sortBy('id');
    }
}
