<?php namespace Radic\Tests\BladeExtensions\Renderers;

use Radic\Tests\BladeExtensions\TestCase;
use Mockery as m;

abstract class RendererTestCase extends TestCase
{

    public function setUp()
    {
        parent::setUp();
    }

    /**
     * getRendererInstance
     *
     * @return \Radic\BladeExtensions\Contracts\MarkdownRenderer;
     *
     */
    abstract protected function getRendererInstance();

    public function testHeader()
    {
        $renderer = $this->getRendererInstance();
        $this->assertEquals('<h1>header</h1>', $renderer->render('# header'));
        $this->assertEquals('<h2>header</h2>', $renderer->render('## header'));
        $this->assertEquals('<h3>header</h3>', $renderer->render('### header'));
        $this->assertEquals('<h4>header</h4>', $renderer->render('#### header'));
        $this->assertEquals('<h5>header</h5>', $renderer->render('##### header'));
        $this->assertEquals('<h6>header</h6>', $renderer->render('###### header'));
    }

    public function testBold()
    {
        $fs     = m::mock('Radic\BladeExtensions\Renderers\ParsedownRenderer')
            ->shouldIgnoreMissing()
            ->shouldReceive('render')
            ->zeroOrMoreTimes()
            ->with('**bold**')
            ->andReturn('<p><strong>bold</strong></p>')
            ->getMock();
        $renderer = $this->getRendererInstance();
        $this->assertEquals('<p><strong>bold</strong></p>', $renderer->render('**bold**'));
    }

    public function testDocblock()
    {
        $renderer = $this->getRendererInstance();
        $this->assertEquals("<!--- docblock -->", $renderer->render("<!--- docblock -->"));
    }
}
