<?php

namespace App\v5;

use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    public function invoices()
    {
        return $this->hasMany('App\v5\Invoice');
    }
}
