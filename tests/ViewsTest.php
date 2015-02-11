<?php namespace Radic\BladeExtensionsTests;

use Illuminate\Html\HtmlServiceProvider;
use Mockery as m;
use Radic\BladeExtensions\BladeExtensionsServiceProvider;
use Radic\BladeExtensions\Traits\BladeViewTestingTrait;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 *
 */
class ViewTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
    }

    public function testSet()
    {
        $this->view->make(
            'set',
            [
                'dataString'        => 'hello',
                'dataArray'         => $this->data->array,
                'dataClassInstance' => $this->data,
                'dataClassName'     => 'TestData'
            ]
        )->render();
    }


    public function testForeach()
    {
        $this->view->make(
            'foreach',
            [
                'dataClass' => $this->data,
                'array'     => $this->data->array,
                'getArray'  => $this->data->getArrayGetterFn()
            ]
        )->render();
    }


    public function testMacros()
    {
        $this->assertEquals('my age is3', $this->view->make('macro')->render());
        $this->assertEquals('my age is 6', $this->view->make('macro2')->render());
        $this->assertEquals('patatmy age is3', $this->view->make('macro3')->render());
    }


    public function testPartials()
    {
        $partials = $this->view->make('partials')->render();
        $this->assertEquals("okokok", str_replace("\n", '', $partials));
    }
}
