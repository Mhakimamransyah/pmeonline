<?php

namespace App\Traits;

trait GetKeysFromArrayTrait {

    /**
     * Get keys from array.
     *
     * @param array $array
     * @return array
     */
    public function getKeysFromArray($array)
    {
        if ($array == null) {
            return array();
        }
        $keys = array();
        foreach ($array as $key => $value) {
            array_push($keys, $key);
        }
        return $keys;
    }

}