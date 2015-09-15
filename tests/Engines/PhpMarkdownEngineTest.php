<?php
namespace Radic\Tests\BladeExtensions\Engines;

use Mockery as m;
use Radic\BladeExtensions\Engines\PhpMarkdownEngine;
use Radic\Tests\BladeExtensions\TestCase;

class PhpMarkdownEngineTest extends TestCase
{
    public function testRender()
    {
        $markdown = m::mock(\Radic\BladeExtensions\Contracts\MarkdownRenderer::class);
        $engine = new PhpMarkdownEngine($markdown);
        $this->assertEquals($engine->getRenderer(), $markdown);
        $markdown->shouldReceive('render')->once()->with("# header\n")->andReturn('<h1>header</h1>');
        $this->assertSame('<h1>header</h1>', $engine->get(__DIR__ . '/../views/markdown/markdown.md'));
    }
}
