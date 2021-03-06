<?php


namespace App\Concept\SubmitValue;


use App\v3\Parameter;

class KimiaAir2019SubmitValue extends AbsSubmitValue
{
    /**
     * @return int
     */
    function lastBottleNumber()
    {
        return 1;
    }

    /**
     * @return int
     */
    function startBottleNumber()
    {
        return 1;
    }

    /**
     * @param int $parameterIndex
     * @param $json
     * @return string
     */
    function parameterAtIndex(int $parameterIndex, $json)
    {
        return 0;
    }

    /**
     * @param $json
     * @param $bottleNumber string
     * @param Parameter $parameter
     * @param $parameterIndex string
     * @return ParameterInput
     */
    function createParameterInput($json, $bottleNumber, Parameter $parameter, $parameterIndex)
    {
        return new KimiaAir2019ParameterInput($json, $bottleNumber, $parameter, $parameter->label);
    }
}