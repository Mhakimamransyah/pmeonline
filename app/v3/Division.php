<?php

namespace App\v3;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
    protected $guarded = [];

    public function packages()
    {
        return $this->belongsToMany('App\v3\Package');
    }
}
