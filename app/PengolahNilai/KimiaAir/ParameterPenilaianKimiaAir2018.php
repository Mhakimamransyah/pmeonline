<?php

namespace App\PengolahNilai\KimiaAir;

use App\Concept\Penilaian\KimiaAir\ParameterPenilaianKimiaAir;

class ParameterPenilaianKimiaAir2018 implements ParameterPenilaianKimiaAir
{
    private $object;

    public function __construct($object)
    {
        $this->object = $object;
    }

    /**
     * Nama parameter.
     *
     * @return string
     */
    public function nama()
    {
        return $this->object->name;
    }

    /**
     * Hasil peserta.
     *
     * @return double
     */
    public function hasilPeserta()
    {
        if ($this->object->hasil == null || $this->object->hasil == '') {
            return '-';
        }
        return $this->object->hasil;
    }

    /**
     * Ketidakpastian.
     *
     * @return double
     */
    public function ketidakpastian()
    {
        if ($this->object->ketidakpastian == '') {
            return '-';
        }
        return $this->object->ketidakpastian;
    }

    /**
     * Nilai evaluasi.
     *
     * @return double
     */
    public function nilaiEvaluasi()
    {
        if (isset($this->object->per_semua->target)) {
            return number_format($this->object->per_semua->target, 3);
        }
        return '-';
    }

    /**
     * SDPA.
     *
     * @return double
     */
    public function sdpa()
    {
        if (isset($this->object->per_semua->sdpa)) {
            return number_format($this->object->per_semua->sdpa, 3);
        }
        return '-';
    }

    /**
     * Z Score.
     *
     * @return double
     */
    public function zscore()
    {
        if (isset($this->object->per_semua->z_score)) {
            return number_format($this->object->per_semua->z_score, 3);
        }
        return '-';
    }

    /**
     * Kategori nilai.
     *
     * @return string
     */
    public function kategori()
    {
        return isset($this->object->per_semua->kategori) ? $this->object->per_semua->kategori : '-';
    }

    /**
     * Kesimpulan penilaian.
     *
     * @return string
     */
    public function kesimpulan()
    {
        return isset($this->object->per_semua->keterangan) ? $this->object->per_semua->keterangan : '-';
    }
}