<?php

namespace App\v3;

use Illuminate\Database\Eloquent\Model;

class Laboratory extends Model
{
    protected $guarded = [];

    public function invoices()
    {
        return $this->hasMany('App\v3\Invoice');
    }

    public function province()
    {
        return $this->belongsTo('App\v3\Province');
    }

    public function getParticipantNumberAttribute()
    {
        $legacyLaboratory = \App\Laboratory::findOrFail($this->id);
        return $legacyLaboratory->participant_number;
    }
}
