<?php


namespace App\Concept\SubmitValue;


class KimiaAir2019ParameterInput extends AbsParameterInput
{
    /**
     * @param $json
     * @param $bottleNumber string
     * @param $parameterIndex int
     * @return string
     */
    function parseValue($json, $bottleNumber, $parameterIndex)
    {
        return $json->{'hasil_pengujian_'.str_replace(" ", "_", $parameterIndex)};
    }

    /**
     * @param $json
     * @param $bottleNumber string
     * @param $parameterIndex int
     * @return string
     */
    function parseEquipment($json, $bottleNumber, $parameterIndex)
    {
        return null;
    }

    /**
     * @param $json
     * @param $bottleNumber string
     * @param $parameterIndex int
     * @return string
     */
    function parseMethod($json, $bottleNumber, $parameterIndex)
    {
        return $json->{'metode_'.str_replace(" ", "_", $parameterIndex)};
    }

    /**
     * @param $json
     * @param $bottleNumber string
     * @param $parameterIndex int
     * @return string
     */
    function parseReagen($json, $bottleNumber, $parameterIndex)
    {
        return $json->{'ketidakpastian_'.str_replace(" ", "_", $parameterIndex)};
    }

    /**
     * @param $json
     * @param $bottleNumber string
     * @param $parameterIndex int
     * @return string
     */
    function parseQualification($json, $bottleNumber, $parameterIndex)
    {
        return null;
    }
}
