<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inject extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public function package()
    {
        return $this->belongsTo('App\Package');
    }

    public function option()
    {
        return $this->belongsTo('App\Option');
    }
}
