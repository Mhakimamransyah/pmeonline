<?php

namespace App\Concept;

interface Laboratorium
{
    /**
     * Nama laboratorium.
     *
     * @return string
     */
    public function nama();

    /**
     * Alamat laboratorium.
     *
     * @return string
     */
    public function alamat();
}