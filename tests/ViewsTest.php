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

        require_once('data/TestData.php');
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



    public function testMacros()
    {
        $this->assertEquals('my age is3', View::make('macro')->render());
        $this->assertEquals('my age is 6', View::make('macro2')->render());
        $this->assertEquals('patatmy age is3', View::make('macro3')->render());
    }



    public function testPartials()
    {
        View::make('partials', ['dataClass' => $this->data, 'array' => $this->data->array, 'getArray' => $this->data->getArrayGetterFn()])->render();

    }


}
