<?php namespace Radic\Tests\BladeExtensions\Directives;

use Illuminate\Html\HtmlServiceProvider;
use Mockery as m;
use Radic\Testing\DataGenerator;
use Radic\Testing\Traits\BladeViewTestingTrait;
use Radic\Tests\BladeExtensions\TestCase;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 *
 */
class ForeachDirectivesTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->loadViewTesting();
        $this->registerHtml();
        $this->registerBlade();
    }


    public function testForeach()
    {
        $dataClass = $this->getData();
        $dataClass->array = DataGenerator::getRecords();
        $this->view()->make(
            'foreach',
            [
                'dataClass' => $this->getData(),
                'array'     => $this->getData()->getRecords(),
                'getArray'  => function(){ return $this->getData()->getValues()['names']; }
            ]
        )->render();
    }

}
