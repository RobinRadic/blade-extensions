<?php namespace Radic\Tests\BladeExtensions\Directives;

use Illuminate\Html\HtmlServiceProvider;
use Mockery as m;
use Radic\Tests\BladeExtensions\TestCase;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 * @group blade-extensions
 */
class MarkdownCompilerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        parent::registerHtml();
        parent::registerBlade();
        parent::registerBladeMarkdown();
    }

    public function testCompile()
    {
        /** @var \Radic\BladeExtensions\Compilers\MarkdownCompiler $compiler */
        $compiler = $this->getCompiler();
        #$this->assertInstanceOf((new MarkdownRenderer($this->app)))$compiler->getRenderer()
        $this->assertTrue(true);
    }

    protected function getCompiler()
    {
        return $this->app->make('markdown.compiler');
    }
}
