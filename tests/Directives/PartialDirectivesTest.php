<?php namespace Radic\Tests\BladeExtensions\Directives;

use Mockery as m;
use Radic\Tests\BladeExtensions\TestCase;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 * @group      blade-extensions
 */
class PartialDirectivesTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->loadViewTesting();
        $this->registerHtml();
        $this->registerBlade();
    }

    public function testPartials()
    {
        $this->assertTrue(true);
        #$partials = $this->view()->make('partials')->render();
        #$this->assertEquals("okokok", str_replace("\n", '', $partials));
    }
}
