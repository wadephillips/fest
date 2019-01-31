<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class BreakoutPresenter extends Pivot
{
  public function breakout()
  {
    return $this->belongsTo('App\Breakout');
  }

  public function presenter()
  {
    return $this->belongsTo('App\Presenter');
  }

}
