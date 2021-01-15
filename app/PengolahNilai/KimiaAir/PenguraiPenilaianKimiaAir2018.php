<?php

namespace App\PengolahNilai\KimiaAir;

use App\Concept\Penilaian\KimiaAir\PenguraiPenilaianKimiaAir;
use App\Concept\Penilaian\KimiaAir\PenilaianKimiaAir;

class PenguraiPenilaianKimiaAir2018 implements PenguraiPenilaianKimiaAir
{
    /**
     * @param $rawData
     * @return PenilaianKimiaAir
     */
    public function urai($rawData)
    {
        return new PenilaianKimiaAir2018($rawData);
    }
}