<?php


namespace App\Concept\SubmitValue;


use App\v3\Package;

interface SubmitValue
{

    /**
     * @return Package
     */
    function getPackage();

    /**
     * @return array
     */
    function getBottles();

}