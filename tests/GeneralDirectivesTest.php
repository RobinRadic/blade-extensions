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
class GeneralDirectivesTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->loadViewTesting();
        $this->registerHtml();
        $this->registerBlade();
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


    public function testPartials()
    {
        $partials = $this->view->make('partials')->render();
        $this->assertEquals("okokok", str_replace("\n", '', $partials));
    }
}
