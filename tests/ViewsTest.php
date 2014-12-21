<?php

use Radic\BladeExtensions\BladeExtensionsServiceProvider;
use Radic\BladeExtensions\Testing\BladeViewTestingTrait;


class ViewTest extends TestBase
{
    use BladeViewTestingTrait;

    protected $data;

    public function setUp()
    {
        parent::setUp();

        require_once('data/TestData.php');
        $this->data = new TestData();


        $this->app->register(new BladeExtensionsServiceProvider($this->app));
        $this->addTestAssertsBladeDirectives();
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
        $partials = View::make('partials')->render();
        $this->assertEquals("okokok", str_replace("\n",'',$partials));
    }


    /**
     * Creates the application.
     *
     * Needs to be implemented by subclasses.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernelInterface
     */
    public function createApplication()
    {
        // TODO: Implement createApplication() method.
    }
}
