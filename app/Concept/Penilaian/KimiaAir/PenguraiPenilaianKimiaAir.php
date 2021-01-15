<?php

namespace App\Concept\Penilaian\KimiaAir;

interface PenguraiPenilaianKimiaAir
{
    /**
     * @param $rawData
     * @return PenilaianKimiaAir
     */
    public function urai($rawData);
}