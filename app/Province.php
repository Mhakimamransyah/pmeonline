<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Province extends Model
{
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Return this province's name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Relationship between Province and Laboratory.
     *
     * @return HasMany
     */
    public function laboratories()
    {
        return $this->hasMany('App\Laboratory');
    }
}
