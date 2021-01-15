<?php

namespace App\PengolahNilai\KimiaAir;

use App\Concept\Penilaian\KimiaAir\ParameterPenilaianKimiaAir;
use App\Concept\Penilaian\KimiaAir\PenilaianKimiaAir;
use App\Concept\Peserta;

class PenilaianKimiaAir2018 implements PenilaianKimiaAir
{
    private $object;

    public function __construct($object)
    {
        $this->object = $object;
    }

    /**
     * Peserta PME bidang Kimia Air.
     *
     * @return Peserta
     */
    public function peserta()
    {
        return new \App\PengolahNilai\Peserta($this->object);
    }

    /**
     * Parameter-parameter yang diujikan.
     *
     * @return array
     */
    public function daftarParameter()
    {
        $resultParameters = array();
        $parameters = $this->object->result->parameters;
        foreach ($parameters as $parameter) {
            $itemParameter = new ParameterPenilaianKimiaAir2018($parameter);
            array_push($resultParameters, $itemParameter);
        }
        return $resultParameters;
    }

    /**
     * Saran untuk peserta berdasarkan hasil yang diperoleh saat pengujian.
     *
     * @return string
     */
    public function saran()
    {
        $parameterOk = [];
        $parameterNotOk = [];
        foreach ($this->daftarParameter() as $parameter) {
            if ($parameter instanceof ParameterPenilaianKimiaAir) {
                if ($parameter->kategori() == 'OK') {
                    array_push($parameterOk, $parameter->nama());
                }
                elseif ($parameter->kategori() == '$' || $parameter->kategori() == '$$') {
                    array_push($parameterNotOk, $parameter->nama());
                }
            }
        }
        $saran = '';
        if (count($parameterOk) > 0) {
            $saran .= 'Diharapkan Saudara mempertahankan hasil pemeriksaan parameter ';

            $last  = array_slice($parameterOk, -1);
            $first = join(', ', array_slice($parameterOk, 0, -1));
            $both  = array_filter(array_merge(array($first), $last), 'strlen');

            $saran .= join(' dan ', $both);
        }
        if (count($parameterNotOk) > 0) {
            if (strlen($saran) > 0) {
                $saran .= '. ';
            }
            $saran .= 'Perbaiki hasil pemeriksaan parameter ';

            $last  = array_slice($parameterNotOk, -1);
            $first = join(', ', array_slice($parameterNotOk, 0, -1));
            $both  = array_filter(array_merge(array($first), $last), 'strlen');

            $saran .= join(' dan ', $both);
            $saran .= ', dengan meneliti kembali cara kerja dan reagen yang digunakan';
        }
        return $saran . '.';
    }
}