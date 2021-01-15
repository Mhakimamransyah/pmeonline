<?php

namespace App;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laboratory extends Model
{
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Set this laboratory's name.
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
     * Set this laboratory's type.
     *
     * @param LaboratoryType $type
     * @return $this
     */
    public function setType(LaboratoryType $type)
    {
        $this->type()->associate($type);
        return $this;
    }

    /**
     * Set this laboratory's ownership.
     *
     * @param LaboratoryOwnership $ownership
     * @return $this
     */
    public function setOwnership(LaboratoryOwnership $ownership)
    {
        $this->ownership()->associate($ownership);
        return $this;
    }

    /**
     * Set this laboratory's address.
     *
     * @param string $address
     * @return $this
     */
    public function setAddress(string $address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * Set this laboratory's village.
     *
     * @param string $village
     * @return $this
     */
    public function setVillage(string $village)
    {
        $this->village = $village;
        return $this;
    }

    /**
     * Set this laboratory's district.
     *
     * @param string $district
     * @return $this
     */
    public function setDistrict(string $district)
    {
        $this->district = $district;
        return $this;
    }

    /**
     * Set this laboratory's city.
     *
     * @param string $city
     * @return $this
     */
    public function setCity(string $city)
    {
        $this->city = $city;
        return $this;
    }

    /**
     * Set this laboratory's province.
     *
     * @param Province $province
     * @return $this
     */
    public function setProvince(Province $province)
    {
        $this->province()->associate($province);
        return $this;
    }

    /**
     * Set this laboratory's postal code.
     *
     * @param string $postalCode
     * @return $this
     */
    public function setPostalCode(string $postalCode)
    {
        $this->postal_code = $postalCode;
        return $this;
    }

    /**
     * Set this laboratory's email.
     *
     * @param string|null $email
     * @return $this
     */
    public function setEmail(?string $email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Set this laboratory's phone number.
     *
     * @param string|null $phoneNumber
     * @return $this
     */
    public function setPhoneNumber(?string $phoneNumber)
    {
        $this->phone_number = $phoneNumber;
        return $this;
    }

    /**
     * Set this laboratory's user.
     *
     * @param User|null $user
     * @return $this
     */
    public function setUser(?User $user)
    {
        $this->user()->associate($user);
        return $this;
    }

    /**
     * Set user's position on this laboratory.
     *
     * @param string|null $userPosition
     * @return $this
     */
    public function setUserPosition(?string $userPosition)
    {
        $this->user_position = $userPosition;
        return $this;
    }

    /**
     * Return this laboratory's id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return this laboratory's name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return this laboratory's type.
     *
     * @return LaboratoryType
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Return this laboratory's ownership.
     *
     * @return LaboratoryOwnership
     */
    public function getOwnership()
    {
        return $this->ownership;
    }

    /**
     * Return this laboratory's address.
     *
     * @return string|null
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**Return this laboratory's village.
     *
     * @return string|null
     */
    public function getVillage()
    {
        return $this->village;
    }

    /**
     * Return this laboratory's district.
     *
     * @return string|null
     */
    public function getDistrict()
    {
        return $this->district;
    }

    /**
     * Return this laboratory's city.
     *
     * @return string|null
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Return this laboratory's province.
     *
     * @return Province
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * Return this laboratory's postal code.
     *
     * @return string|null
     */
    public function getPostalCode()
    {
        return $this->postal_code;
    }

    /**
     * Return this laboratory's email.
     *
     * @return string|null
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Return this laboratory's phone number.
     *
     * @return string|null
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * Return this laboratory's user.
     *
     * @return User|null
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Return this laboratory's user's position.
     *
     * @return string|null
     */
    public function getUserPosition()
    {
        return $this->user_position;
    }

    /**
     * Return this laboratory's invoices.
     *
     * @return Collection
     */
    public function getInvoices()
    {
        return $this->invoices;
    }

    /**
     * Relationship between Laboratory and LaboratoryType.
     *
     * @return BelongsTo
     */
    public function type()
    {
        return $this->belongsTo('App\LaboratoryType');
    }

    /**
     * Relationship between Laboratory and LaboratoryOwnership.
     *
     * @return BelongsTo
     */
    public function ownership()
    {
        return $this->belongsTo('App\LaboratoryOwnership');
    }

    /**
     * Relationship between Laboratory and Province.
     *
     * @return BelongsTo
     */
    public function province()
    {
        return $this->belongsTo('App\Province');
    }

    /**
     * Relationship between Laboratory and User.
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    /**
     * Relationship between Laboratory and Invoice.
     *
     * @return HasMany
     */
    public function invoices()
    {
        return $this->hasMany('App\Invoice');
    }

    /**
     * Return collection of *paid* invoices belongs to this laboratory.
     *
     * @param Cycle $cycle
     * @return Collection of paid invoices belongs to this laboratory.
     */
    public function getInvoicesForCycle(Cycle $cycle)
    {
        return $this->invoices()->with(['orders', 'orders.package', 'orders.submit'])->get()->filter(function (Invoice $invoice) use ($cycle) {
            $cycleIds = $invoice->getCycles()->map(function (Cycle $cycle) {
                return $cycle->id;
            })->unique()->toArray();
            return in_array($cycle->id, $cycleIds) && !$invoice->isUnpaid();
        })->values();
    }

    /**
     * Return this laboratory's participated packages for particular cycle.
     *
     * @param Cycle $cycle
     * @return Collection
     */
    public function getPackagesParticipatedForCycle(Cycle $cycle)
    {
        return $this->getOrdersParticipatedForCycle($cycle)->flatMap(function (Order $order) use ($cycle) {
            return $order->package()->without(['cycle'])->get();
        })->filter(function (Package $package) use ($cycle) {
            return $package->cycle_id == $cycle->id;
        })->values();
    }

    /**
     * Return this laboratory's registered packages for particular cycle.
     *
     * @param Cycle $cycle
     * @return Collection
     */
    public function getPackagesRegisteredForCycle(Cycle $cycle)
    {
        return $this->getOrdersRegisteredForCycle($cycle)->flatMap(function (Order $order) use ($cycle) {
            return $order->package()->without(['cycle'])->get();
        })->filter(function (Package $package) use ($cycle) {
            return $package->cycle_id == $cycle->id;
        })->values();
    }

    /**
     * Return this laboratory's participated orders for particular cycle.
     *
     * @param Cycle $cycle
     * @return Collection
     */
    public function getOrdersParticipatedForCycle(Cycle $cycle)
    {
        return $this->filterOrdersForCycle($cycle, function (Invoice $invoice, array $invoiceCyclesId) use ($cycle) {
            return ($invoice->isPaymentVerified() || $invoice->isPaymentInDebt()) && in_array($cycle->id, $invoiceCyclesId);
        });
    }

    /**
     * Return this laboratory's registered orders for particular cycle.
     *
     * @param Cycle $cycle
     * @return Collection
     */
    public function getOrdersRegisteredForCycle(Cycle $cycle)
    {
        return $this->filterOrdersForCycle($cycle, function (Invoice $invoice, array $invoiceCyclesId) use ($cycle) {
            return !$invoice->isUnpaid() && in_array($cycle->id, $invoiceCyclesId);
        });
    }

    /**
     * Filter orders by cycle and given criteria.
     *
     * @param Cycle $cycle
     * @param $invoiceFilter Callback with Invoice $invoice, and array $invoiceCyclesId as parameters.
     * @return Collection
     */
    private function filterOrdersForCycle(Cycle $cycle, $invoiceFilter)
    {
        $invoices = $this->invoices()->without(['laboratory'])->get()->filter(function (Invoice $invoice) use($cycle, $invoiceFilter) {
            $invoiceCyclesId = $invoice->orders()->with(['package'])->get()->flatMap(function (Order $order) {
                return $order->package()->get();
            })->map(function (Package $package) {
                return $package->cycle_id;
            })->unique()->toArray();
            return $invoiceFilter($invoice, $invoiceCyclesId);
        });
        $orders = $invoices->flatMap(function (Invoice $invoice) use ($cycle) {
            return $invoice->orders()->get()->filter(function (Order $order) use ($cycle) {
                return $order != null;
            });
        });
        return $orders;
    }

    public function getParticipantNumberAttribute()
    {
        $override_participant_number = $this->attributes['participant_number'];
        if ($override_participant_number == null || $override_participant_number == '' || strlen($override_participant_number) < 2) {
            return $this->province->participant_code . '-' . $this->type->participant_code . '-' .  str_pad($this->id, 5, '0', STR_PAD_LEFT);
        }
        return $override_participant_number;
    }
}
