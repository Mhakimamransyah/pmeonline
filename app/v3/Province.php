<?php

namespace App\v3;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    protected $guarded = [];

    public function laboratories()
    {
        return $this->hasMany('App\v3\Laboratory');
    }
}
