<?php namespace Radic\Tests\BladeExtensions\Renderers;

use Radic\BladeExtensions\Renderers\ParsedownRenderer;

class ParsedownRendererTest extends RendererTestCase
{
    protected function getRendererInstance()
    {
        return new ParsedownRenderer(new \Parsedown(), $this->app['config']);
    }
}
