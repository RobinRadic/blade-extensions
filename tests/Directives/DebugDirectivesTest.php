<?php namespace Radic\Tests\BladeExtensions\Directives;

use Mockery as m;
use Radic\Tests\BladeExtensions\TestCase;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 * @group      blade-extensions
 */
class DebugDirectivesTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
        $this->loadViewTesting();
        $this->registerHtml();
    }

    public function testDebugVardump()
    {
        return;
        $this->app[ 'config' ]->set('blade_extensions.directives.addDebug', '<pre><code><?php var_dump($1) ?></code></pre>');#<?php var_dump($1) ? >
        $this->registerBlade();
        $rendered = $this->view()->make('debug')->render();
        $this->assertEquals(<<<'EOT'
<pre><code>string(3) "sdf"
</code></pre>

EOT
        , $rendered, 'testDebugVardump should render the exact value');
    }

    public function testBreakpoint()
    {
        $this->registerBlade();
        #$this->assertEquals("<!-- breakpoint -->bool(true)\n", $this->view()->make('breakpoint')->render());
    }
}
