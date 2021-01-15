<?php

namespace App\LittleFlower;


class FormInputParser
{
    public static function parse($item)
    {
        $result = json_decode($item->value);
        $result->id = $item->id;
        $result->order_package_id = $item->order_package_id;
        return $result;
    }
}