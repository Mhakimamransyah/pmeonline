<?php

namespace App\v5;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public function package()
    {
        return $this->belongsTo('App\v5\Package');
    }

    public function invoice()
    {
        return $this->belongsTo('App\v5\Invoice');
    }
}
