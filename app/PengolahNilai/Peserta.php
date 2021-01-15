<?php

namespace App\PengolahNilai;

use App\Concept\Laboratorium;

class Peserta implements \App\Concept\Peserta
{
    private $object;

    public function __construct($object)
    {
        $this->object = $object;
    }

    /**
     * Nomor peserta.
     *
     * @return string
     */
    public function nomorPeserta()
    {
        return $this->object->participant_number;
    }

    /**
     * Laboratorium peserta.
     *
     * @return Laboratorium
     */
    public function laboratorium()
    {
        return new \App\PengolahNilai\Laboratorium($this->object->laboratory);
    }
}