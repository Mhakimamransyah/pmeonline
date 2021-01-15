<?php

namespace App\v5;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cycle extends Model
{
    use SoftDeletes;

    protected $dates = [
        'start_registration_date', 'end_registration_date', 'start_submit_date', 'end_submit_date'
    ];

    public function packages()
    {
        return $this->hasMany('App\v5\Package');
    }

    public function getIsOpenRegistrationAttribute()
    {
        return Carbon::now()->isAfter($this->start_registration_date) && (Carbon::now()->isBefore($this->end_registration_date) || $this->end_registration_date->isCurrentDay());
    }

    public function getIsOpenSubmitAttribute()
    {
        return Carbon::now()->isAfter($this->start_submit_date) && (Carbon::now()->isBefore($this->end_submit_date) || $this->end_submit_date->isCurrentDay());
    }

    public function getHasNotStartedAttribute()
    {
        return Carbon::now()->isBefore($this->start_registration_date) && Carbon::now()->isBefore($this->end_registration_date)
            && Carbon::now()->isBefore($this->start_submit_date) && Carbon::now()->isBefore($this->end_submit_date);
    }

    public function getHasDoneAttribute()
    {
        return Carbon::now()->isAfter($this->start_registration_date) && Carbon::now()->isAfter($this->end_registration_date)
            && Carbon::now()->isAfter($this->start_submit_date) && Carbon::now()->isAfter($this->end_submit_date);
    }
}
