<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SimpleCycle extends Model
{
    protected $guarded = [];

    protected $table = 'cycles';

    protected $appends = [
        'packages',
    ];

    public function getPackagesAttribute()
    {
        return $this->hasMany('App\Package', 'cycle_id', 'id')->get();
    }
}
