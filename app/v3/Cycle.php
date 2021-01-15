<?php

namespace App\v3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cycle extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function packages()
    {
        return $this->hasMany('App\v3\Package');
    }
}
