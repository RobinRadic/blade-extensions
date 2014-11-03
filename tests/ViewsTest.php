<?php

use Mockery as m;
use Radic\BladeExtensions\BladeExtensionsServiceProvider;
use Radic\BladeExtensions\Testing\BladeViewTestingTrait;

class ViewTest extends Orchestra\Testbench\TestCase
{
    use BladeViewTestingTrait;

    protected $data;

    public function setUp()
    {
        parent::setUp();

        require_once('TestData.php');
        $this->data = new TestData();

        $this->addTestAssertsBladeDirectives();

        $this->app->register(new BladeExtensionsServiceProvider($this->app));
        //$this->app->register(new IdeHelperServiceProvider($this->app));
        //$this->app->artisan->call('ide-helper:generate');

        View::addLocation(__DIR__ . '/views');
    }


    public function testSet()
    {
        //print_r($this->data);
        View::make('set', ['dataString' => 'hello', 'dataArray' => $this->data->array, 'dataClassInstance' => $this->data, 'dataClassName' => 'TestData'])->render();
    }


    public function testForeach()
    {
        View::make('foreach', ['dataClass' => $this->data, 'array' => $this->data->array, 'getArray' => $this->data->getArrayGetterFn()])->render();
    }


}