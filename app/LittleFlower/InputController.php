<?php

namespace App\LittleFlower;

use App\Package;
use App\Province;
use App\Sanitizer\HematologiSanitizer;
use App\Sanitizer\HemostatisSanitizer;
use App\Sanitizer\KimiaAirSanitizer;
use App\Sanitizer\KimiaKlinikSanitizer;
use App\Sanitizer\UrinalisaSanitizer;
use App\ScoreInput;
use Illuminate\Support\Collection;

class InputController
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

    public static function proceed2($package_id)
    {
        $inputs = \App\FormInput::where('value', '!=', null)
            ->whereHas('orderPackage', function ($query) use ($package_id) {
                return $query->where('package_id', '=', $package_id);
            })->get()
            ->load(['orderPackage', 'orderPackage.order']);

        $provinces = Province::all()->load(['laboratories']);
        foreach ($provinces as $province) {
            foreach ($province->laboratories as $laboratory) {
                $input = $inputs->first(function ($item) use ($laboratory) {
                    return $item->orderPackage->order->laboratory_id == $laboratory->id;
                });
                if ($input != null) {
                    $laboratory->input = FormInputParser::parse($input);
                } else {
                    $laboratory->input = null;
                }

                $score = ScoreInput::where('order_package_id', '=', $input['order_package_id'])->first();
                $laboratory->score_id = $score['id'];
                $laboratory->score = json_decode($score['value']);
            }
        }

        foreach ($provinces as $province) {
            $province->data = $province->laboratories->filter(function ($item) {
                return $item->input != null;
            })->values();
            unset($province->laboratories);
        }

        return $provinces->filter(function ($item) {
            return count($item->data) > 0;
        })->values();
    }

    public static function proceedMalaria($package_id)
    {
        $inputs = \App\MalariaFormInput::all()
            ->load(['orderPackage', 'orderPackage.order']);

        $provinces = Province::all()->load(['laboratories']);
        foreach ($provinces as $province) {
            foreach ($province->laboratories as $laboratory) {
                $input = $inputs->first(function ($item) use ($laboratory) {
                    return $item->orderPackage['order']['laboratory_id'] == $laboratory->id;
                });
                if ($input != null) {
                    $laboratory->input = $input;
                } else {
                    $laboratory->input = null;
                }

                $score = ScoreInput::where('order_package_id', '=', $input['order_package_id'])->first();
                $laboratory->score_id = $score['id'];
                $laboratory->score = json_decode($score['value']);
            }
        }

        foreach ($provinces as $province) {
            $province->data = $province->laboratories->filter(function ($item) {
                return $item->input != null;
            })->values();
            unset($province->laboratories);
        }

        return $provinces->filter(function ($item) {
            return count($item->data) > 0;
        })->values();
    }

}