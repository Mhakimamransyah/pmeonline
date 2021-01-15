<?php

namespace App\v5;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    public function orders()
    {
        return $this->hasMany('App\v5\Order');
    }

    public function laboratory()
    {
        return $this->belongsTo('App\v5\Laboratory');
    }

    public function payment()
    {
        return $this->hasOne('App\v5\Payment');
    }
}
