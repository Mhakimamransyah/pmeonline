<?php


namespace App\Concept\SubmitValue;


use App\v3\Parameter;

class KimiaKlinik2019SubmitValue extends AbsSubmitValue
{
    /**
     * @return int
     */
    function lastBottleNumber()
    {
        return 2;
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
        return $json->{'parameter_name_'.$parameterIndex};
    }

    public function createParameterInput($json, $bottleNumber, Parameter $parameter, $parameterIndex)
    {
        return new KimiaKlinik2019ParameterInput($json, $bottleNumber, $parameter, $parameterIndex);
    }
}