<?php


namespace App\Concept\SubmitValue;


class Hematologi2019ParameterInput extends AbsParameterInput
{
    /**
     * @param $json
     * @param $bottleNumber string
     * @param $parameterIndex int
     * @return string
     */
    function parseValue($json, $bottleNumber, $parameterIndex)
    {
        return $json->{'hasil_'.$parameterIndex.'_bottle_'.$bottleNumber};
    }

    /**
     * @param $json
     * @param $bottleNumber string
     * @param $parameterIndex int
     * @return string
     */
    function parseEquipment($json, $bottleNumber, $parameterIndex)
    {
        return $json->{'equipment_'.$parameterIndex.'_bottle_'.$bottleNumber};
    }

    /**
     * @param $json
     * @param $bottleNumber string
     * @param $parameterIndex int
     * @return string
     */
    function parseMethod($json, $bottleNumber, $parameterIndex)
    {
        return $json->{'method_'.$parameterIndex.'_bottle_'.$bottleNumber};
    }

    /**
     * @param $json
     * @param $bottleNumber string
     * @param $parameterIndex int
     * @return string
     */
    function parseReagen($json, $bottleNumber, $parameterIndex)
    {
        return null;
    }

    /**
     * @param $json
     * @param $bottleNumber string
     * @param $parameterIndex int
     * @return string
     */
    function parseQualification($json, $bottleNumber, $parameterIndex)
    {
        return $json->{'kualifikasi_pemeriksa_'.$parameterIndex.'_bottle_'.$bottleNumber};
    }
}