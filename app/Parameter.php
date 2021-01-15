<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Parameter extends Model
{
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Set this parameter's label.
     *
     * @param string $label
     * @return $this
     */
    public function setLabel(string $label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * Set this parameter's unit.
     *
     * @param string $unit
     * @return $this
     */
    public function setUnit(string $unit)
    {
        $this->unit = $unit;
        return $this;
    }

    /**
     * Set this parameter's package.
     *
     * @param Package $package
     * @return $this
     */
    public function setPackage(Package $package)
    {
        $this->package()->associate($package);
        return $this;
    }

    /**
     * Return this parameter's id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return this parameter's label.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Return this parameter's unit.
     *
     * @return string|null
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * Return this parameter's package.
     *
     * @return Package
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * Relationship between Parameter and Package.
     *
     * @return BelongsTo
     */
    public function package()
    {
        return $this->belongsTo('App\Package');
    }
}
