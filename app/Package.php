<?php

namespace App;

use App\Traits\RupiahFormatterTrait;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Package extends Model
{
    use SoftDeletes, RupiahFormatterTrait;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    protected $appends = [
        'divisions',
    ];

    /**
     * Set this package's name. See #getName for more info.
     *
     * @param string $name
     * @return $this
     */
    public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Set this package's label.
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
     * Set this package's tariff.
     *
     * @param float $tariff
     * @return $this
     */
    public function setTariff(float $tariff)
    {
        $this->tariff = $tariff;
        return $this;
    }

    /**
     * Set this package's quota.
     *
     * @param int $quota
     * @return $this
     */
    public function setQuota(int $quota)
    {
        $this->quota = $quota;
        return $this;
    }

    /**
     * Set this package's cycle.
     *
     * @param Cycle $cycle
     * @return $this
     */
    public function setCycle(Cycle $cycle)
    {
        $this->cycle()->associate($cycle);
        return $this;
    }

    /**
     * Return this package's id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return this package's name.
     * This field is used to determine which form and preview to be shown for this package.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return this package's label.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Return this package's tariff.
     *
     * @return float
     */
    public function getTariff()
    {
        return $this->tariff;
    }

    /**
     * Return this package's quota.
     *
     * @return int
     */
    public function getQuota()
    {
        return $this->quota;
    }

    /**
     * Return this package's cycle.
     *
     * @return Cycle
     */
    public function getCycle()
    {
        return $this->cycle;
    }

    /**
     * Return this package's parameters.
     *
     * @return Collection
     */
    public function getParameters()
    {
        return $this->parameters;
    }

    /**
     * Return this package's orders.
     *
     * @return Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Relationship between Package and Cycle.
     *
     * @return BelongsTo
     */
    public function cycle()
    {
        return $this->belongsTo('App\Cycle');
    }

    /**
     * Relationship between Package and Parameter.
     *
     * @return HasMany
     */
    public function parameters()
    {
        return $this->hasMany('App\Parameter');
    }

    /**
     * Relationship between Package and Order.
     *
     * @return HasMany
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    /**
     * Display this package's tariff.
     *
     * @return string
     */
    public function displayTariff()
    {
        return $this->rupiah($this->tariff);
    }

    /**
     * Relationship between Package and Division.
     *
     * @return BelongsToMany
     */
    public function divisions()
    {
        return $this->belongsToMany('App\Division');
    }

    public function getDivisionsAttribute()
    {
        return $this->divisions()->get();
    }

    public function certificate()
    {
        return $this->hasOne('App\Certificate');
    }

    public function injects()
    {
        return $this->hasMany('App\Inject');
    }
}
