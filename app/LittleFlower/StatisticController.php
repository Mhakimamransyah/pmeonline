<?php

namespace App\LittleFlower;

class StatisticController
{
    public static function findOverall($package_id, $bottle_id, $parameter_name)
    {
        $input = collect(InputController::proceed($package_id))->map(function ($item) use ($bottle_id) {
            return $item->bottles[$bottle_id];
        })->map(function ($item) use ($parameter_name) {
            $parameters = collect($item->parameters);
            return $parameters->first(function ($parameter) use ($parameter_name) {
                return $parameter->name == $parameter_name;
            });
        })->filter(function ($item) {
            return $item->hasil != null;
        });
        $input = array_values($input->toArray());
        $input = collect($input)->map(function ($item) {
            return $item->hasil;
        });
        return $input;
    }

    public static function findOverallRaw($package_id, $bottle_id, $parameter_name)
    {
        $input = collect(InputController::proceed($package_id))->map(function ($item) use ($bottle_id) {
            return $item->bottles[$bottle_id];
        })->map(function ($item) use ($parameter_name) {
            $parameters = collect($item->parameters);
            return $parameters->first(function ($parameter) use ($parameter_name) {
                return $parameter->name == $parameter_name;
            });
        })->filter(function ($item) {
            return $item->hasil_raw != null;
        });
        $input = array_values($input->toArray());
        $input = collect($input)->map(function ($item) {
            return $item->hasil_raw;
        });
        return $input;
    }

    public static function findByMethod($package_id, $bottle_id, $parameter_name, $method_id)
    {
        $input = collect(InputController::proceed($package_id))->map(function ($item) use ($bottle_id) {
            return $item->bottles[$bottle_id];
        })->map(function ($item) use ($parameter_name) {
            $parameters = collect($item->parameters);
            return $parameters->first(function ($parameter) use ($parameter_name) {
                return $parameter->name == $parameter_name;
            });
        })->filter(function ($item) use ($method_id) {
            return $item->hasil != null && $item->metode == $method_id;
        });
        $input = array_values($input->toArray());
        $input = collect($input)->map(function ($item) {
            return $item->hasil;
        });
        return $input;
    }

    public static function findByEquipment($package_id, $bottle_id, $parameter_name, $equipment_id)
    {
        $input = collect(InputController::proceed($package_id))->map(function ($item) use ($bottle_id) {
            return $item->bottles[$bottle_id];
        })->map(function ($item) use ($parameter_name) {
            $parameters = collect($item->parameters);
            return $parameters->first(function ($parameter) use ($parameter_name) {
                return $parameter->name == $parameter_name;
            });
        })->filter(function ($item) use ($equipment_id) {
            return $item->hasil != null && $item->alat == $equipment_id;
        });
        $input = array_values($input->toArray());
        $input = collect($input)->map(function ($item) {
            return $item->hasil;
        });
        return $input;
    }
}