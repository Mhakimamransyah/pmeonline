<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Division extends Model
{
    protected $guarded = [];

    const DIVISION_PATHOLOGY = "pathology";

    const DIVISION_IMMUNOLOGY = "immunology";

    const DIVISION_MICROBIOLOGY = "microbiology";

    const DIVISION_HEALTH_CHEMICAL = "health-chemical";

    public static function pathology()
    {
        return Division::query()->where('name', self::DIVISION_PATHOLOGY)->first();
    }

    public static function immunology()
    {
        return Division::query()->where('name', self::DIVISION_IMMUNOLOGY)->first();
    }

    public static function microbiology()
    {
        return Division::query()->where('name', self::DIVISION_MICROBIOLOGY)->first();
    }

    public static function healthChemical()
    {
        return Division::query()->where('name', self::DIVISION_HEALTH_CHEMICAL)->first();
    }

    public function hasPackage(Package $package)
    {
        return $this->packages()->get()->contains($package);
    }

    /**
     * Relationship between Division and Package.
     *
     * @return BelongsToMany
     */
    public function packages()
    {
        return $this->belongsToMany('App\Package');
    }
}
