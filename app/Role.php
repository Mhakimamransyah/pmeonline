<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use SoftDeletes;

    /**
     * Name for administrator role.
     */
    const ROLE_ADMIN = "role.admin";

    /**
     * Name for participant role.
     */
    const ROLE_PARTICIPANT = "role.participant";

    /**
     * Name for pathology division role.
     */
    const ROLE_DIVISION_PATHOLOGY = 'role.division.pathology';

    /**
     * Name for microbiology division role.
     */
    const ROLE_DIVISION_MICROBIOLOGY = 'role.division.microbiology';

    /**
     * Name for health chemical division role.
     */
    const ROLE_DIVISION_HEALTH_CHEMICAL = 'role.division.health-chemical';

    /**
     * Name for immunology division role.
     */
    const ROLE_DIVISION_IMMUNOLOGY = 'role.division.immunology';

    /**
     * Path for pathology division role.
     */
    const ROLE_DIVISION_PATHOLOGY_PATH = 'patologi';

    /**
     * Path for microbiology division role.
     */
    const ROLE_DIVISION_MICROBIOLOGY_PATH = 'mikrobiologi';

    /**
     * Path for health chemical division role.
     */
    const ROLE_DIVISION_HEALTH_CHEMICAL_PATH = 'kimia-kesehatan';

    /**
     * Path for immunology division role.
     */
    const ROLE_DIVISION_IMMUNOLOGY_PATH = 'imunologi';

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
        'is_registration_allowed' => 'boolean',
        'is_login_allowed' => 'boolean',
    ];

    protected $appends = [
        'division',
    ];

    /**
     * Relationship between Role and User.
     *
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany('App\User');
    }

    /**
     * Set this role's name.
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
     * Set this role's label.
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
     * Set true if registration is allowed for this role. Otherwise, set false.
     *
     * @param bool $allowed
     * @return $this
     */
    public function setRegistrationAllowed(bool $allowed)
    {
        $this->is_registration_allowed = $allowed;
        return $this;
    }

    /**
     * Set true if login is allowed for this role. Otherwise, set false.
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
     * Return this role's id.
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Return this role's name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return this role's label.
     *
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * Return true if registration is allowed for this role. Otherwise, return false.
     *
     * @return boolean
     */
    public function isAllowedToRegister()
    {
        return $this->is_registration_allowed;
    }

    /**
     * Return true if users of this role is allowed to login. Otherwise, return false.
     *
     * @return boolean
     */
    public function isAllowedToLogin()
    {
        return $this->is_login_allowed;
    }

    /**
     * Retrieve administrator role.
     *
     * @return Role|mixed
     */
    public static function administrator()
    {
        return self::query()->where('name', self::ROLE_ADMIN)->first();
    }

    /**
     * Retrieve participant role.
     *
     * @return Role|mixed
     */
    public static function participant()
    {
        return self::query()->where('name', self::ROLE_PARTICIPANT)->first();
    }

    public function getDivisionAttribute()
    {
        return $this->division()->get()->first();
    }

    /**
     * Relationship between Role and Division.
     *
     * @return BelongsTo
     */
    public function division()
    {
        return $this->belongsTo('App\Division');
    }

    /**
     * Find role by name.
     *
     * @param string $roleName
     * @return Role|mixed
     */
    public static function findRoleByName(string $roleName)
    {
        return self::query()->where('name', $roleName)->first();
    }
}
