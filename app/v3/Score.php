<?php

namespace App\v3;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Score extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function order()
    {
        return $this->belongsTo('App\v3\Order');
    }
}
