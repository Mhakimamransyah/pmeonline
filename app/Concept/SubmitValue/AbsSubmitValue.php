<?php


namespace App\Concept\SubmitValue;


use App\v3\Package;
use App\v3\Parameter;
use App\v3\Submit;

abstract class AbsSubmitValue implements SubmitValue
{

    private $json;

    var $bottles = [];

    private $package;

    /**
     * @return int
     */
    abstract function lastBottleNumber();

    /**
     * @return int
     */
    abstract function startBottleNumber();

    /**
     * @param int $parameterIndex
     * @param $json
     * @return string
     */
    abstract function parameterAtIndex(int $parameterIndex, $json);

    /**
     * @param $json
     * @param $bottleNumber string
     * @param Parameter $parameter
     * @param $parameterIndex string
     * @return ParameterInput
     */
    abstract function createParameterInput($json, $bottleNumber, Parameter $parameter, $parameterIndex);

    public function __construct(Submit $submit)
    {
        $this->json = json_decode($submit->value);
        $this->package = $submit->order->package;
        for ($bottleNumber = $this->startBottleNumber(); $bottleNumber <= $this->lastBottleNumber(); $bottleNumber++) {
            $bottle = new \stdClass();
            $bottle->number = $bottleNumber;
            $bottle->data = [];
            foreach ($this->package->parameters as $parameter) {
                $index = 0;
                for ($i = 0; $i < count($this->package->parameters); $i++) {
                    $parameterAtIndex = $this->parameterAtIndex($i, $this->json);
                    if ($parameterAtIndex == null) {
                        $parameterAtIndex = $this->package->parameters[$i]->label;
                    }
                    if ($parameterAtIndex == $parameter->label) {
                        $index = $i;
                        break;
                    }
                }
                $datum = $this->createParameterInput($this->json, $bottleNumber, $parameter, $index);

                array_push($bottle->data, $datum);
            }
            array_push($this->bottles, $bottle);
        }
    }

    /**
     * @return Package
     */
    public function getPackage()
    {
        return $this->package;
    }

    /**
     * @return array
     */
    public function getBottles()
    {
        return $this->bottles;
    }

}