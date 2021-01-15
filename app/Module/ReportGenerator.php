<?php

namespace App\Module;

use App\LittleFlower\FormInputParser;
use App\Sanitizer\HematologiSanitizer;
use App\Sanitizer\HemostatisSanitizer;
use App\Sanitizer\KimiaAirSanitizer;
use App\Sanitizer\KimiaKlinikSanitizer;
use App\Sanitizer\UrinalisaSanitizer;

class ReportGenerator
{

    public static function proceed($package_id)
    {
        $inputs = \App\FormInput::where('value', '!=', null)
            ->whereHas('orderPackage', function ($query) use ($package_id) {
                return $query->where('package_id', '=', $package_id);
            })
            ->get()
            ->map(function ($item) {
                return FormInputParser::parse($item);
            });
        if ($package_id == 1) {
            return KimiaKlinikSanitizer::sanitize($inputs);
        }
        if ($package_id == 2) {
            return HematologiSanitizer::sanitize($inputs);
        }
        if ($package_id == 3) {
            return UrinalisaSanitizer::sanitize($inputs);
        }
        if ($package_id == 4) {
            return HemostatisSanitizer::sanitize($inputs);
        }
        if ($package_id == 13) {
            return KimiaAirSanitizer::sanitize($inputs);
        }
        return $inputs;
    }

    public static function sanitizeInput($input, $package_id) {
        if ($package_id == 1) {
            return KimiaKlinikSanitizer::sanitizeItem($input);
        }
        if ($package_id == 2) {
            return HematologiSanitizer::sanitizeItem($input);
        }
        if ($package_id == 3) {
            return UrinalisaSanitizer::sanitizeItem($input);
        }
        if ($package_id == 4) {
            return HemostatisSanitizer::sanitizeItem($input);
        }
        if ($package_id == 13) {
            return KimiaAirSanitizer::sanitizeItem($input);
        }
        return $input;
    }

}