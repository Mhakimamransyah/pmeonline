<?php


namespace App\Concept\SubmitValue;


class KimiaKlinik2019ParameterInput extends AbsParameterInput
{
    /**
     * @param $json
     * @param $bottleNumber string
     * @param $parameterIndex int
     * @return string
     */
    function parseValue($json, $bottleNumber, $parameterIndex)
    {
        return $json->{'hasil_'.$parameterIndex.'_'.$bottleNumber};
    }

    /**
     * @param $json
     * @param $bottleNumber string
     * @param $parameterIndex int
     * @return string
     */
    function parseEquipment($json, $bottleNumber, $parameterIndex)
    {
        return $json->{'alat_'.$parameterIndex.'_'.$bottleNumber};
    }

    /**
     * @param $json
     * @param $bottleNumber string
     * @param $parameterIndex int
     * @return string
     */
    function parseMethod($json, $bottleNumber, $parameterIndex)
    {
        return $json->{'metode_pemeriksaan_'.$parameterIndex.'_'.$bottleNumber};
    }

    /**
     * @param $json
     * @param $bottleNumber string
     * @param $parameterIndex int
     * @return string
     */
    function parseReagen($json, $bottleNumber, $parameterIndex)
    {
        return $json->{'reagen_'.$parameterIndex.'_'.$bottleNumber};
    }

    /**
     * @param $json
     * @param $bottleNumber string
     * @param $parameterIndex int
     * @return string
     */
    function parseQualification($json, $bottleNumber, $parameterIndex)
    {
        return $json->{'qualification_'.$parameterIndex.'_'.$bottleNumber};
    }
}