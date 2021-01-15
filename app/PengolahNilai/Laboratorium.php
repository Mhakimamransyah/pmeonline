<?php

namespace App\PengolahNilai;

class Laboratorium implements \App\Concept\Laboratorium
{
    private $object;

    public function __construct($object)
    {
        $this->object = $object;
    }

    /**
     * Nama laboratorium.
     *
     * @return string
     */
    public function nama()
    {
        return $this->object->name;
    }

    /**
     * Alamat laboratorium.
     *
     * @return string
     */
    public function alamat()
    {
        return $this->object->address;
    }
}