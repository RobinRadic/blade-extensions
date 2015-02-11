<?php namespace Radic\BladeExtensionsTests;

class TestData
{

    public $array;

    protected $_array;

    public $json;

    public static $name = 'john';

    public $someVal = 'maria';


    public function __construct()
    {
        $this->json   = file_get_contents(__DIR__ . '/data/data.json');
        $this->array  = json_decode($this->json, true);
        $this->_array = json_decode($this->json, true);
    }

    public function getArray($protected = false)
    {
        return $protected === true ? $this->_array : $this->array;
    }

    public function getArrayGetterFn()
    {
        return function ($protected = false) {
            return $protected === true ? $this->_array : $this->array;
        };
    }
}
