<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Breakout extends Model
{

  public function presenters()
  {
      return $this->belongsToMany('App\Presenter')->using('App\BreakoutPresenter');
  }
}
