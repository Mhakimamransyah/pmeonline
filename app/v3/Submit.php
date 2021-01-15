<?php

namespace App\v3;

use Illuminate\Database\Eloquent\Model;

class Submit extends Model
{
    protected $guarded = [];

    protected $casts = [
        'sent' => 'boolean',
        'verified' => 'boolean',
    ];

    public function order()
    {
        return $this->belongsTo('App\v3\Order');
    }
}
