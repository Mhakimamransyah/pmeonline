<?php

namespace App;

use App\Notifications\ResetPasswordNotification;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'role',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'is_login_allowed' => 'boolean',
    ];

    public function getRoleAttribute()
    {
        return $this->role()->get()->first();
    }

    /**
     * Relationship between User and Role.
     * @return BelongsTo
     */
    public function role()
    {
        return $this->belongsTo('App\Role');
    }

    /**
     * Returns true if this user is an administrator account.
     *
     * @return bool
     */
    public function isAdministrator()
    {
        return $this->getRole()->is(Role::administrator());
    }

    /**
     * Return true if this user is a participant account.
     *
     * @return bool
     */
    public function isParticipant()
    {
        return $this->getRole()->is(Role::participant());
    }

    /**
     * Return true if this user is an installation account.
     *
     * @return bool
     */
    public function isInstallation()
    {
        return $this->role()->count() > 0 && $this->role->division_id != null;
    }

    /**
     * Return true if this user has role with particular role name.
     * 
     * @param string $roleName
     * @return bool
     */
    public function hasRole(string $roleName)
    {
        return $this->getRole()->is(Role::findRoleByName($roleName));
    }

    /**
     * Set this user's name.
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
     * Set this user's email.
     *
     * @param string $email
     * @return $this
     */
    public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * Set this user's password. Hash password before storing it to storage.
     *
     * @param string $password
     * @return $this
     */
    public function setPassword(string $password)
    {
        $this->password = Hash::make($password);
        return $this;
    }

    /**
     * Set this user's phone number.
     *
     * @param string $phoneNumber
     * @return $this
     */
    public function setPhoneNumber(string $phoneNumber)
    {
        $this->phone_number = $phoneNumber;
        return $this;
    }

    /**
     * Set this user's role.
     *
     * @param Role $role
     * @return $this
     */
    public function setRole(Role $role)
    {
        $this->role()->associate($role);
        return $this;
    }

    /**
     * Set true if this user is allowed to login. Otherwise, set false.
     *
     * @param bool $allowed
     * @return $this
     */
    public function setLoginAllowed(bool $allowed)
    {
        $this->is_login_allowed = $allowed;
        return $this;
    }

    /**
     * Return this user's id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return this user's name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return this user's email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Return this user's hashed password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Return this user's phone number.
     *
     * @return string|null
     */
    public function getPhoneNumber()
    {
        return $this->phone_number;
    }

    /**
     * Return this user's role.
     *
     * @return Role|null
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Return invoices belongs to this user.
     *
     * @return Collection
     */
    public function getInvoices()
    {
        return $this->getLaboratories()->map(function ($laboratory) {
            if (!$laboratory instanceof Laboratory) { return abort(500); }
            return $laboratory->getInvoices();
        })->flatten()->sortByDesc(function ($item) {
            return $item['created_at'];
        });
    }

    /**
     * Return invoices need payment belongs to this user.
     *
     * @return Collection
     */
    public function getInvoicesNeedPayment()
    {
        return $this->getInvoices()->filter(function ($invoice) {
            if (!$invoice instanceof Invoice) { return abort(500); }
            return $invoice->isPaymentInDebt() || $invoice->isPaymentWaitingVerification() || $invoice->isUnpaid();
        });
    }

    /**
     * Return invoices that this user allowed to submit form input.
     *
     * @return Collection
     */
    public function getInvoicesAllowedToSubmit()
    {
        return $this->getInvoices()->filter(function ($invoice) {
            if (!$invoice instanceof Invoice) { return abort(500); }
            return $invoice->isPaymentInDebt() || $invoice->isPaymentVerified();
        });
    }

    /**
     * Return orders that this user allowed to submit form input.
     *
     * @return Collection|mixed
     */
    public function getOrdersAllowedToSubmit()
    {
        return $this->getOrdersParticipated()->filter(function ($order) {
            if (!$order instanceof Order) { abort(500); }
            return $order->getCycle()->isOpenSubmit();
        })->flatten();
    }

    /**
     * Return orders that this user is participated on particular orders.
     *
     * @return Collection|mixed
     */
    public function getOrdersParticipated()
    {
        return $this->getInvoicesAllowedToSubmit()->flatMap(function ($invoice) {
            if (!$invoice instanceof Invoice) { abort(500); }
            return $invoice->getOrders();
        })->flatten();
    }

    /**
     * Return true if this user is allowed to login. Otherwise, return false.
     *
     * @return boolean
     */
    public function isAllowedToLogin()
    {
        if ($this->role == null) {
            return false;
        }
        return $this->is_login_allowed;
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Return target email to send with SendGrid notification channel.
     *
     * @return string
     */
    public function routeNotificationForSendGrid()
    {
        return $this->getEmail();
    }

    /**
     * Relationship between User and Laboratory.
     *
     * @return HasMany
     */
    public function laboratories()
    {
        return $this->hasMany('App\Laboratory');
    }

    /**
     * Return this user's laboratories.
     *
     * @return Collection
     */
    public function getLaboratories()
    {
        return $this->laboratories;
    }

    /**
     * Return list of users registered with Role::participant() role.
     *
     * @return Builder[]|Collection
     */
    public static function participants()
    {
        return static::query()->where('role_id', '=', Role::participant()->getId())->get();
    }
}
