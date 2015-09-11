<?php namespace Radic\Tests\BladeExtensions\Directives;

use Mockery as m;
use Radic\Tests\BladeExtensions\TestCase;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 * @group      blade-extensions
 */
class MinifyDirectivesTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->loadViewTesting();
        $this->registerHtmlServiceProvider();
        $this->registerServiceProvider();
    }

    /**
     * getViews
     *
     * @return \Illuminate\View\Factory
     */
    protected function getViews()
    {
        return $this->app->make('view');
    }


    # THE most silly tests ever
    # actually its just to see if the minification works :>
    public function testHtmlMinification()
    {
        $rendered = $this->getViews()->make('minify/html')->render();
        $this->assertTrue(true);
    }
    public function testJsMinification()
    {
        $rendered = $this->getViews()->make('minify/js')->render();
        $this->assertTrue(true);
    }
    public function testCssMinification()
    {
        $rendered = $this->getViews()->make('minify/css')->render();
        $this->assertTrue(true);
    }
}
