<?php

namespace App\Concept\Penilaian\KimiaAir;

interface ParameterPenilaianKimiaAir
{
    /**
     * Nama parameter.
     *
     * @return string
     */
    public function nama();

    /**
     * Hasil peserta.
     *
     * @return double
     */
    public function hasilPeserta();

    /**
     * Ketidakpastian.
     *
     * @return double
     */
    public function ketidakpastian();

    /**
     * Nilai evaluasi.
     *
     * @return double
     */
    public function nilaiEvaluasi();

    /**
     * SDPA.
     *
     * @return double
     */
    public function sdpa();

    /**
     * Z Score.
     *
     * @return double
     */
    public function zscore();

    /**
     * Kategori nilai.
     *
     * @return string
     */
    public function kategori();

    /**
     * Kesimpulan penilaian.
     *
     * @return string
     */
    public function kesimpulan();
}