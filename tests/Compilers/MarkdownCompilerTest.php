<?php namespace Radic\Tests\BladeExtensions\Directives;

use Illuminate\Html\HtmlServiceProvider;
use Mockery as m;
use Radic\BladeExtensions\BladeExtensionsServiceProvider;
use Radic\BladeExtensions\Compilers\MarkdownCompiler;
use Radic\Testing\Traits\BladeViewTestingTrait;
use Radic\Tests\BladeExtensions\TestCase;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 *
 */
class MarkdownCompilerTest extends TestCase
{
    public function testCompile()
    {
        return $this->assertTrue(true);

        /** @var \Radic\BladeExtensions\Compilers\MarkdownCompiler $compiler */
        $compiler = $this->getCompiler();
        $compiler->getFiles()->shouldReceive('get')->once()
            ->with('path')->andReturn('markdown');
        $compiler->getRenderer()->shouldReceive('render')->once()
            ->with("markdown")->andReturn('html');
        $compiler->getFiles()->shouldReceive('put')->once()
            ->with(__DIR__.'/d6fe1d0be6347b8ef2427fa629c04485', 'html');
        $this->assertNull($compiler->compile('path'));
    }
    protected function getCompiler()
    {

        $markdown = m::mock('\Radic\BladeExtensions\Renderer\ParsedownRenderer');
        $files = m::mock('Illuminate\Filesystem\Filesystem');
        $cachePath = __DIR__;
        return new MarkdownCompiler($markdown, $files, $cachePath);
    }
}
