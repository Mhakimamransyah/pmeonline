<?php

namespace App\v3;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    public function package()
    {
        return $this->belongsTo('App\v3\Package');
    }

    public function invoice()
    {
        return $this->belongsTo('App\v3\Invoice');
    }

    public function submit()
    {
        return $this->hasOne('App\v3\Submit');
    }

    public function score()
    {
        return $this->hasOne('App\v3\Score');
    }
}
