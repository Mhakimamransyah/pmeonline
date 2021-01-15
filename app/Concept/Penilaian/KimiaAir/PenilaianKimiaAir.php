<?php

namespace App\Concept\Penilaian\KimiaAir;

use App\Concept\Peserta;

interface PenilaianKimiaAir
{
    /**
     * Peserta PME bidang Kimia Air.
     *
     * @return Peserta
     */
    public function peserta();

    /**
     * Parameter-parameter yang diujikan.
     *
     * @return array
     */
    public function daftarParameter();

    /**
     * Saran untuk peserta berdasarkan hasil yang diperoleh saat pengujian.
     *
     * @return string
     */
    public function saran();
}