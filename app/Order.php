<?php

namespace App;

use App\Traits\RupiahFormatterTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes, RupiahFormatterTrait;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'subtotal' => 'double'
    ];

    /**
     * Set this order's invoice.
     *
     * @param Invoice $invoice
     * @return $this
     */
    public function setInvoice(Invoice $invoice)
    {
        $this->invoice()->associate($invoice);
        return $this;
    }

    /**
     * Set this order's package.
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
     * Set this order's subtotal.
     *
     * @param float $subtotal
     * @return $this
     */
    public function setSubtotal(float $subtotal)
    {
        $this->subtotal = $subtotal;
        return $this;
    }

    /**
     * Return this order's id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return this order's invoice.
     *
     * @return Invoice
     */
    public function getInvoice()
    {
        return $this->invoice;
    }

    /**
     * Return this order's package.
     *
     * @return Package
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * Return this order's subtotal.
     *
     * @return float
     */
    public function getSubtotal()
    {
        return $this->subtotal;
    }

    /**
     * Return this order's cycle.
     *
     * @return Cycle
     */
    public function getCycle()
    {
        return $this->getPackage()->getCycle();
    }

    /**
     * Return this order's submit.
     *
     * @return Submit|null
     */
    public function getSubmit()
    {
        return $this->submit;
    }

    /**
     * Relationship between Order and Submit.
     *
     * @return HasOne
     */
    public function submit()
    {
        return $this->hasOne('App\Submit');
    }

    /**
     * Relationship between Order and Invoice.
     *
     * @return BelongsTo
     */
    public function invoice()
    {
        return $this->belongsTo('App\Invoice');
    }

    /**
     * Relationship between Order and Package.
     *
     * @return BelongsTo
     */
    public function package()
    {
        return $this->belongsTo('App\Package');
    }

    /**
     * Return this order's subtotal in rupiah formatted.
     *
     * @return string
     */
    public function displaySubTotal()
    {
        return $this->rupiah($this->subtotal);
    }

    public function getLaboratoryNameAttribute()
    {
        try {
            return $this->invoice->laboratory->name;
        } catch (\Exception $e) {
            return '-';
        }
    }

    public function getLaboratoryProvinceAttribute()
    {
        try {
            return $this->invoice->laboratory->province->name;
        } catch (\Exception $e) {
            return '-';
        }
    }

    public function getParticipantNumberAttribute()
    {
        try {
            return $this->invoice->laboratory->participant_number;
        } catch (\Exception $e) {
            return '-';
        }
    }

    public function score()
    {
        return $this->hasOne('App\Score');
    }
}
