<?php


namespace App\Concept\SubmitValue;


use App\v3\Parameter;

abstract class AbsParameterInput implements ParameterInput
{

    var $value;

    var $equipment;

    var $method;

    var $reagen;

    var $qualification;

    var $parameter;

    private $parameterIndex;

    public function __construct($json, $bottleNumber, Parameter $parameter, $parameterIndex)
    {
        $this->parameter = $parameter;
        $this->parameterIndex = $parameterIndex;
        $this->value = $this->parseValue($json, $bottleNumber, $parameterIndex);
        $this->equipment = $this->parseEquipment($json, $bottleNumber, $parameterIndex);
        $this->method = $this->parseMethod($json, $bottleNumber, $parameterIndex);
        $this->reagen = $this->parseReagen($json, $bottleNumber, $parameterIndex);
        $this->qualification = $this->parseQualification($json, $bottleNumber, $parameterIndex);
    }

    /**
     * @param $json
     * @param $bottleNumber string
     * @param $parameterIndex int
     * @return string
     */
    abstract function parseValue($json, $bottleNumber, $parameterIndex);

    /**
     * @param $json
     * @param $bottleNumber string
     * @param $parameterIndex int
     * @return string
     */
    abstract function parseEquipment($json, $bottleNumber, $parameterIndex);

    /**
     * @param $json
     * @param $bottleNumber string
     * @param $parameterIndex int
     * @return string
     */
    abstract function parseMethod($json, $bottleNumber, $parameterIndex);

    /**
     * @param $json
     * @param $bottleNumber string
     * @param $parameterIndex int
     * @return string
     */
    abstract function parseReagen($json, $bottleNumber, $parameterIndex);

    /**
     * @param $json
     * @param $bottleNumber string
     * @param $parameterIndex int
     * @return string
     */
    abstract function parseQualification($json, $bottleNumber, $parameterIndex);

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @return string
     */
    public function getEquipment(): string
    {
        return $this->equipment;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return string
     */
    public function getReagen(): string
    {
        return $this->reagen;
    }

    /**
     * @return string
     */
    public function getQualification(): string
    {
        return $this->qualification;
    }

    /**
     * @return Parameter
     */
    public function getParameter(): Parameter
    {
        return $this->parameter;
    }

}