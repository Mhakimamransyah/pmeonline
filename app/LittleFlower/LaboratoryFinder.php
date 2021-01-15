<?php

namespace App\LittleFlower;


use App\OrderPackage;

class LaboratoryFinder
{
    public static function findByOrderPackage($order_package_id)
    {
        $orderPackage = OrderPackage::find($order_package_id);
        return $orderPackage->order->laboratory;
    }
}