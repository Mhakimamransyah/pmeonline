<?php

namespace App\v3;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $guarded = [];

    public function orders()
    {
        return $this->hasMany('App\v3\Order');
    }

    public function laboratory()
    {
        return $this->belongsTo('App\v3\Laboratory');
    }
}
