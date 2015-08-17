<?php namespace Radic\Tests\BladeExtensions\Directives;

use Mockery as m;
use Radic\Tests\BladeExtensions\DataGenerator;
use Radic\Tests\BladeExtensions\TestCase;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 * @group      blade-extensions
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
        $dataClass        = static::getData();
        $dataClass->array = DataGenerator::getRecords();
        $this->view()->make(
            'foreach',
            [
                'dataClass' => static::getData(),
                'array'     => static::getData()->getRecords(),
                'getArray'  => function () {
                
                    return static::getData()->getValues()[ 'names' ];
                }
            ]
        )->render();
    }

    public function testIssue11()
    {
        $this->view()->make(
            'issue11',
            [
                'array' => static::getData()->getRecords()
            ]
        )->render();
    }
}
