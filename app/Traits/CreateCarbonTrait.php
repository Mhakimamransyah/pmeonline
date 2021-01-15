<?php

namespace App\Traits;

use Carbon\Carbon;

trait CreateCarbonTrait
{
    function createCarbon($stringDate)
    {
        if ($stringDate != null) {
            return new Carbon($stringDate);
        }
        return null;
    }
}