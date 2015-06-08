<?php namespace Radic\Tests\BladeExtensions\Renderers;

use Radic\BladeExtensions\Renderers\ParsedownRenderer;

class ParsedownRendererTest extends RendererTestCase
{
    /**
     * getRendererInstance
     *
     * @return \Radic\BladeExtensions\Renderers\ParsedownRenderer
     */
    protected function getRendererInstance()
    {
        return new ParsedownRenderer(new \Parsedown(), $this->app['config']);
    }
}
