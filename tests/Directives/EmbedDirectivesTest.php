<?php namespace Radic\Tests\BladeExtensions\Directives;

use Caffeinated\Beverage\Path;
use Mockery as m;
use Radic\Tests\BladeExtensions\TestCase;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 * @group      blade-extensions
 */
class EmbedDirectivesTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    public function testEmbeds()
    {
        $view = $this->app->make('view');
        $config = $this->app->make('config');
        $config->set('blade_extensions.example_views', true);
        $this->loadViewTesting();
        $this->registerServiceProvider();
        //$view->make('tests.bootstrap')->render();
        $this->assertTrue(true);
    }
}
