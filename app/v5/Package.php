<?php

namespace App\v5;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    public function cycle()
    {
        return $this->belongsTo('App\v5\Cycle');
    }

    public function orders()
    {
        return $this->hasMany('App\v5\Order');
    }
}
