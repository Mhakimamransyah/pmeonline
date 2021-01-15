<?php

namespace App;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cycle extends Model
{
    use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'errors',
        'is_open_registration',
        'is_open_submit',
        'has_not_started',
        'has_done',
        'laboratories',
        'participants',
        'laboratories_count',
        'participants_count',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'start_registration_date', 'end_registration_date', 'start_submit_date', 'end_submit_date'
    ];

    /**
     * Return collection of cycles that still open for registration.
     *
     * @return Builder
     */
    public static function openRegistration()
    {
        return self::query()->where('start_registration_date', '<=', Carbon::now())
            ->where('end_registration_date', '>=', Carbon::now());
    }

    /**
     * Return true if this cycle is open for registration.
     *
     * @return bool
     */
    public function isOpenRegistration()
    {
        return Carbon::now()->isAfter($this->getStartRegistrationDate()) && (Carbon::now()->isBefore($this->getEndRegistrationDate()) || $this->getEndRegistrationDate()->isCurrentDay());
    }

    /**
     * Return true if this cycle is open for submit.
     *
     * @return bool
     */
    public function isOpenSubmit()
    {
        return Carbon::now()->isAfter($this->getStartSubmitDate()) && (Carbon::now()->isBefore($this->getEndSubmitDate()) || $this->getEndSubmitDate()->isCurrentDay());
    }

    /**
     * Return true if this cycle has not started. (so it is "considered safe" to edit this cycle)
     *
     * @return bool
     */
    public function hasNotStarted()
    {
        return Carbon::now()->isBefore($this->getStartRegistrationDate()) && Carbon::now()->isBefore($this->getEndRegistrationDate())
            && Carbon::now()->isBefore($this->getStartSubmitDate()) && Carbon::now()->isBefore($this->getEndSubmitDate());
    }

    /**
     * Return true if this cycle has done.
     *
     * @return bool
     */
    public function hasDone()
    {
        return Carbon::now()->isAfter($this->getStartRegistrationDate()) && Carbon::now()->isAfter($this->getEndRegistrationDate())
            && Carbon::now()->isAfter($this->getStartSubmitDate()) && Carbon::now()->isAfter($this->getEndSubmitDate());
    }

    /**
     * Return this cycle's error.
     *
     * @return Collection
     */
    public function errors()
    {
        $errors = Collection::make();
        $slicedBetweenRegistrationAndSubmitDate = $this->slicedBetweenRegistrationAndSubmitDate();
        if ($slicedBetweenRegistrationAndSubmitDate->count() > 0) {
            $firstDateSliced = $slicedBetweenRegistrationAndSubmitDate->first()->formatLocalized('%e %B %Y');
            $lastDateSliced = $slicedBetweenRegistrationAndSubmitDate->last()->formatLocalized('%e %B %Y');
            if ($firstDateSliced == $lastDateSliced) {
                $errors->add(__('Pendaftaran dan pengisian laporan dibuka secara bersamaan (' . $firstDateSliced . ').'));
            } else {
                $errors->add(__('Pendaftaran dan pengisian laporan dibuka secara bersamaan (' . $firstDateSliced . ' - ' . $lastDateSliced . ').'));
            }
        }
        if ($this->getEndRegistrationDate()->isBefore($this->getStartRegistrationDate())) {
            $errors->add(__('Pendaftaran ditutup sebelum dibuka.'));
        }
        if ($this->getEndSubmitDate()->isBefore($this->getStartSubmitDate())) {
            $errors->add(__('Pengisian laporan ditutup sebelum dibuka.'));
        }
        return $errors;
    }

    public function getErrorsAttribute()
    {
        return $this->errors();
    }

    public function getIsOpenSubmitAttribute()
    {
        return $this->isOpenSubmit();
    }

    public function getIsOpenRegistrationAttribute()
    {
        return $this->isOpenRegistration();
    }

    public function getHasNotStartedAttribute()
    {
        return $this->hasNotStarted();
    }

    public function getHasDoneAttribute()
    {
        return $this->hasDone();
    }

    /**
     * Return sliced date between registration and submit date.
     *
     * @return Collection
     */
    public function slicedBetweenRegistrationAndSubmitDate()
    {
        $registrationPeriod = CarbonPeriod::between($this->getStartRegistrationDate(), $this->getEndRegistrationDate());
        $submitFilter = function (Carbon $date) {
            return $date->between($this->getStartSubmitDate(), $this->getEndSubmitDate());
        };
        return Collection::make($registrationPeriod->addFilter($submitFilter)->toArray());
    }

    /**
     * Set this cycle's name.
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
     * Set this cycle's year.
     *
     * @param int $year
     * @return $this
     */
    public function setYear(int $year)
    {
        $this->year = $year;
        return $this;
    }

    /**
     * Set this cycle's start registration date.
     *
     * @param Carbon $date
     * @return $this
     */
    public function setStartRegistrationDate(Carbon $date)
    {
        $this->start_registration_date = $date;
        return $this;
    }

    /**
     * Set this cycle's end registration date.
     *
     * @param Carbon $date
     * @return $this
     */
    public function setEndRegistrationDate(Carbon $date)
    {
        $this->end_registration_date = $date;
        return $this;
    }

    /**
     * Set this cycle's start submit date.
     *
     * @param Carbon $date
     * @return $this
     */
    public function setStartSubmitDate(Carbon $date)
    {
        $this->start_submit_date = $date;
        return $this;
    }

    /**
     * Set this cycle's end submit date.
     *
     * @param Carbon $date
     * @return $this
     */
    public function setEndSubmitDate(Carbon $date)
    {
        $this->end_submit_date = $date;
        return $this;
    }

    /**
     * Return this cycle's id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return this cycle's name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return this cycle's year.
     *
     * @return int
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Return this cycle's start registration date.
     *
     * @return Carbon
     */
    public function getStartRegistrationDate()
    {
        return $this->start_registration_date;
    }

    /**
     * Return this cycle's end registration date.
     *
     * @return Carbon
     */
    public function getEndRegistrationDate()
    {
        return $this->end_registration_date;
    }

    /**
     * Return this cycle's end registration date display.
     *
     * @return string
     */
    public function getEndRegistrationDateDisplay()
    {
        return Carbon::parse($this->getEndRegistrationDate())->locale('id')->diffForHumans();
    }

    /**
     * Return this cycle's start submit date.
     *
     * @return Carbon
     */
    public function getStartSubmitDate()
    {
        return $this->start_submit_date;
    }

    /**
     * Return this cycle's end submit date.
     *
     * @return Carbon
     */
    public function getEndSubmitDate()
    {
        return $this->end_submit_date;
    }

    /**
     * Return this cycle's end submit date display.
     *
     * @return string
     */
    public function getEndSubmitDateDisplay()
    {
        return Carbon::parse($this->getEndSubmitDate())->locale('id')->diffForHumans();
    }

    /**
     * Return this cycle's packages.
     *
     * @return Collection
     */
    public function getPackages()
    {
        return $this->packages;
    }

    /**
     * Relationship between Cycle and Package.
     *
     * @return HasMany
     */
    public function packages()
    {
        return $this->hasMany('App\Package');
    }

    /**
     * Return this cycle's orders.
     *
     * @return Collection
     */
    public function getOrdersAttribute()
    {
        return Order::query()
            ->whereIn('package_id', $this->getPackages()
                ->map(function ($package) {
                    return $package->id;
                }))
            ->get();
    }

    public function getUnpaidOrdersAttribute()
    {
        return Invoice::query()
            ->whereIn('id', $this->getOrdersAttribute()
                ->map(function ($order) {
                    return $order->invoice_id;
                }))
            ->get()
            ->filter(function (Invoice $invoice) {
                return $invoice->isPaymentInDebt() || $invoice->isUnpaid();
            });
    }

    /**
     * Return this cycle's invoices.
     *
     * @return Collection
     */
    public function getInvoicesAttribute()
    {
        return Invoice::query()
            ->whereIn('id', $this->getOrdersAttribute()
                ->map(function ($order) {
                    return $order->invoice_id;
                }))
            ->get()
            ->filter(function (Invoice $invoice) {
                return !$invoice->isUnpaid();
            });
    }

    /**
     * Return this cycle's participant invoices.
     *
     * @return Collection
     */
    public function getParticipantInvoicesAttribute()
    {
        return $this->getInvoicesAttribute()->filter(function (Invoice $invoice) {
            return $invoice->isPaymentInDebt() || $invoice->isPaymentVerified();
        })->values();
    }

    /**
     * Return this cycle's invoices count.
     *
     * @return int
     */
    public function getInvoicesCountAttribute()
    {
        return $this->getInvoicesAttribute()->count();
    }

    /**
     * Return this cycle's participant invoice count.
     *
     * @return int
     */
    public function getParticipantInvoicesCountAttribute()
    {
        return $this->getParticipantInvoicesAttribute()->count();
    }

    /**
     * Return list of laboratories registered for this cycles.
     *
     * @return Collection
     */
    public function getLaboratoriesAttribute()
    {
        return Laboratory::query()
            ->whereIn('id', $this->getInvoicesAttribute()
                ->map(function (Invoice $invoice) {
                    return $invoice->laboratory_id;
                }))
            ->get()
            ->unique();
    }

    /**
     * Return list of laboratories participated for this cycles.
     *
     * @return Collection
     */
    public function getParticipantsAttribute()
    {
        return Laboratory::query()
            ->whereIn('id', $this->getParticipantInvoicesAttribute()
                ->map(function ($invoice) {
                    return $invoice->laboratory_id;
                }))
            ->with(['province', 'user'])
            ->get()
            ->unique();
    }

    public function filterParticipants($query)
    {
        return Laboratory::query()
            ->where('name', 'LIKE', '%'.$query.'%', 'or')
            ->whereIn('id', $this->getParticipantInvoicesAttribute()
                ->map(function ($invoice) {
                    return $invoice->laboratory_id;
                }))
            ->with(['province', 'user'])
            ->get()
            ->unique();
    }

    /**
     * Return count of laboratories registered for this cycles.
     *
     * @return int
     */
    public function getLaboratoriesCountAttribute()
    {
        return $this->getLaboratoriesAttribute()->count();
    }

    /**
     * Return count of laboratories participated for this cycles.
     *
     * @return int
     */
    public function getParticipantsCountAttribute()
    {
        return $this->getParticipantsAttribute()->count();
    }
}
