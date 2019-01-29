<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presenter extends Model
{

  public function breakouts()
  {
    return $this->belongsToMany('App\Breakouts')->using('App\PresenterBreakouts');
  }

}
