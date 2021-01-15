<?php

namespace App\v3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parameter extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function package()
    {
        return $this->belongsTo('App\v3\Package');
    }
}
