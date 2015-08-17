<?php namespace Radic\Tests\BladeExtensions\Directives;

use Mockery as m;
use Radic\Tests\BladeExtensions\TestCase;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 * @group      blade-extensions
 */
class AssignmentDirectivesTest extends TestCase
{

    /**
     * Setup the test case
     */
    public function setUp()
    {
        parent::setUp();
        $this->loadViewTesting();
        $this->registerHtml();
        $this->registerBlade();
    }

    /**
     * Test the set directive
     */
    public function testSet()
    {
        $this->view()->make('assignment', [
            'dataString'        => 'hello',
            'dataArray'         => $this->getData()->getValues()[ 'names' ],
            'dataClassInstance' => $this->getData(),
            'dataClassName'     => 'DataGenerator'
        ])->render();
    }
}
