<?php namespace Radic\Tests\BladeExtensions\Directives;

use Radic\BladeExtensions\Renderers\ParsedownRenderer;
use Radic\Tests\BladeExtensions\TestCase;

class ParsedownRendererTest extends TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    protected function makeParsedownRendererClass()
    {
        return new ParsedownRenderer(new \Parsedown(), $this->app['config']);
    }

    public function testRenderHeader()
    {
        $renderer = $this->makeParsedownRendererClass();
        $this->assertEquals('<h1>header</h1>', $renderer->render('# header'));
        $this->assertEquals('<h2>header</h2>', $renderer->render('## header'));
        $this->assertEquals('<h3>header</h3>', $renderer->render('### header'));
        $this->assertEquals('<h4>header</h4>', $renderer->render('#### header'));
        $this->assertEquals('<h5>header</h5>', $renderer->render('##### header'));
        $this->assertEquals('<h6>header</h6>', $renderer->render('###### header'));
    }
}
