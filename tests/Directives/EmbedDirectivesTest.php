<?php namespace Radic\Tests\BladeExtensions\Directives;

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
        $this->loadViewTesting();
        $this->registerHtmlServiceProvider();
        $this->registerServiceProvider();
    }

    public function testEmbeds()
    {
        $this->assertTrue(true);
    }


}
