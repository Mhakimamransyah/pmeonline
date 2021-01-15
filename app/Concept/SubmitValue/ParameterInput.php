<?php


namespace App\Concept\SubmitValue;


use App\v3\Parameter;

interface ParameterInput
{

    /**
     * @return string
     */
    function getValue();

    /**
     * @return string
     */
    function getEquipment();

    /**
     * @return string
     */
    function getMethod();

    /**
     * @return string
     */
    function getReagen();

    /**
     * @return string
     */
    function getQualification();

    /**
     * @return Parameter
     */
    function getParameter();

}