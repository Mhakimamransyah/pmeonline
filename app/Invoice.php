<?php

namespace App;

use App\Traits\RupiahFormatterTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use SoftDeletes, RupiahFormatterTrait;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'created_at', 'updated_at'
    ];

    protected $casts = [
        'boolean' => 'is_eligible_to_submit',
    ];

    /**
     * Set this invoice's owner.
     *
     * @param Laboratory $laboratory
     * @return $this
     */
    public function setLaboratory(Laboratory $laboratory)
    {
        $this->laboratory()->associate($laboratory);
        return $this;
    }

    /**
     * Set this invoice's total cost.
     *
     * @param float $cost
     * @return $this
     */
    public function setTotalCost(float $cost)
    {
        $this->total_cost = $cost;
        return $this;
    }

    /**
     * Return this invoice's id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return this invoice's laboratory.
     *
     * @return Laboratory
     */
    public function getLaboratory()
    {
        return $this->laboratory;
    }

    /**
     * Return this invoice's total cost.
     *
     * @return float
     */
    public function getTotalCost()
    {
        return $this->total_cost;
    }

    /**
     * Return this invoice's orders.
     *
     * @return Collection
     */
    public function getOrders()
    {
        return $this->orders;
    }

    /**
     * Return this invoice's cycles.
     *
     * @return Collection
     */
    public function getCycles()
    {
        return $this->orders()->get()->flatMap(function (Order $order) {
            return $order->package()->get();
        })->map(function (Package $package) {
            return $package->cycle()->first();
        })->unique();
    }

    /**
     * Return this invoice's payment.
     *
     * @return Payment|null
     */
    public function getPayment()
    {
        return $this->payment;
    }

    /**
     * Return this invoice's created date in human readable format.
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return Carbon::parse($this->created_at)->locale('id')->diffForHumans();
    }

    /**
     * Relationship between Invoice and Laboratory.
     *
     * @return BelongsTo
     */
    public function laboratory()
    {
        return $this->belongsTo('App\Laboratory');
    }

    /**
     * Relationship between Invoice and Order.
     *
     * @return HasMany
     */
    public function orders()
    {
        return $this->hasMany('App\Order');
    }

    /**
     * Display total cost.
     *
     * @return string
     */
    public function displayTotalCost()
    {
        return $this->rupiah($this->total_cost);
    }

    /**
     * Relationship between Invoice and Payment.
     *
     * @return HasOne
     */
    public function payment()
    {
        return $this->hasOne('App\Payment');
    }

    /**
     * Return true if this invoice is unpaid.
     *
     * @return bool
     */
    public function isUnpaid()
    {
        return $this->getPayment() == null;
    }

    /**
     * Return true if this invoice's payment is waiting for verification.
     *
     * @return bool
     */
    public function isPaymentWaitingVerification()
    {
        $payment = $this->getPayment();
        if ($payment == null) {
            return false;
        }
        return $payment->isWaitingVerification();
    }

    /**
     * Return true if this invoice's payment is verified.
     *
     * @return bool
     */
    public function isPaymentVerified()
    {
        $payment = $this->getPayment();
        if ($payment == null) {
            return false;
        }
        return $payment->isVerified();
    }

    /**
     * Return true if this invoice's payment is rejected.
     *
     * @return bool
     */
    public function isPaymentRejected()
    {
        $payment = $this->getPayment();
        if ($payment == null) {
            return false;
        }
        return $payment->isRejected();
    }

    /**
     * Return true if this invoice's payment is in debt.
     *
     * @return bool
     */
    public function isPaymentInDebt()
    {
        $payment = $this->getPayment();
        if ($payment == null) {
            return false;
        }
        return $payment->isInDebt();
    }

    protected $appends = [
        'is_unpaid',
        'is_payment_waiting_verification',
        'is_payment_verified',
        'is_payment_rejected',
        'is_payment_in_debt',
    ];

    public function getIsUnpaidAttribute()
    {
        return $this->isUnpaid();
    }

    public function getIsPaymentWaitingVerificationAttribute()
    {
        return $this->isPaymentWaitingVerification();
    }

    public function getIsPaymentVerifiedAttribute()
    {
        return $this->isPaymentVerified();
    }

    public function getIsPaymentRejectedAttribute()
    {
        return $this->isPaymentRejected();
    }

    public function getIsPaymentInDebtAttribute()
    {
        return $this->isPaymentInDebt();
    }

    public function getIsEligibleToSubmitAttribute()
    {
        return $this->payment != null && in_array($this->payment->state, [Payment::STATE_DEBT, Payment::STATE_VERIFIED]);
    }
}
