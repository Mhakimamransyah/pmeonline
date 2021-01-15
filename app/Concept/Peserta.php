<?php

namespace App\Concept;

interface Peserta
{
    /**
     * Nomor peserta.
     *
     * @return string
     */
    public function nomorPeserta();

    /**
     * Laboratorium peserta.
     *
     * @return Laboratorium
     */
    public function laboratorium();
}