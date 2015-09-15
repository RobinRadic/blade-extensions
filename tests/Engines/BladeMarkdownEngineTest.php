<?php
namespace Radic\Tests\BladeExtensions\Engines;

use Illuminate\View\Compilers\CompilerInterface;
use Mockery as m;
use Radic\BladeExtensions\Engines\BladeMarkdownEngine;
use Radic\Tests\BladeExtensions\TestCase;

class BladeMarkdownEngineTest extends TestCase
{
    public function testRender()
    {
        $compiler = m::mock(CompilerInterface::class);
        $markdown = m::mock(\Radic\BladeExtensions\Contracts\MarkdownRenderer::class);
        $path = __DIR__ . '/../views/markdown/markdown.md';
        $compiler->shouldReceive('isExpired')->once()->with($path)->andReturn(false);
        $compiler->shouldReceive('getCompiledPath')->once()->andReturn($path);
        $engine = new BladeMarkdownEngine($compiler, $markdown);
        $this->assertEquals($engine->getRenderer(), $markdown);
        $markdown->shouldReceive('render')->once()->with("# header\n")->andReturn('<h1>header</h1>');
        $this->assertSame('<h1>header</h1>', $engine->get($path));
    }
}
