<?php

namespace App\v3;

use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    protected $guarded = [];

    public function cycle()
    {
        return $this->belongsTo('App\v3\Cycle');
    }

    public function divisions()
    {
        return $this->belongsToMany('App\v3\Division');
    }

    public function orders()
    {
        return $this->hasMany('App\v3\Order');
    }

    public function parameters()
    {
        return $this->hasMany('App\v3\Parameter');
    }
}
