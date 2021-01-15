<?php

namespace App\Traits;


trait ImploderTrait
{
    function imploder($array)
    {
        if ($array == null) {
            return null;
        }
        return implode(',', $array);
    }
}