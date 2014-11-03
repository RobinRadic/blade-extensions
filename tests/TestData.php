<?php


class TestData
{
    public $array;
    protected $_array;

    public $json;

    public function __construct()
    {
        $this->json = File::get(__DIR__ . '/data.json');
        $this->array = json_decode($this->json, true);
        $this->_array = json_decode($this->json, true);
    }

    public function getArray($protected = false)
    {
        return $protected === true ? $this->_array : $this->array;
    }

    public function getArrayGetterFn()
    {
        return function($protected = false){
            return $protected === true ? $this->_array : $this->array;
        };
    }

} 