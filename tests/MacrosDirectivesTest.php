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
class MacrosDirectivesTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->loadViewTesting();
    }

    public function testMacros()
    {
        $this->registerHtml();
        $this->registerBlade();
        $this->assertEquals('my age is3', $this->view->make('macro')->render());
        $this->assertEquals('my age is 6', $this->view->make('macro2')->render());
        $this->assertEquals('patatmy age is3', $this->view->make('macro3')->render());
    }

}
