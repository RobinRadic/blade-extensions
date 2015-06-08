<?php namespace Radic\Tests\BladeExtensions\Renderers;

use Ciconia\Ciconia;
use Radic\BladeExtensions\Renderers\CiconiaRenderer;

class CiconiaRendererTest extends RendererTestCase
{
    protected function getRendererInstance()
    {
        return new CiconiaRenderer(new Ciconia(), $this->app['config']);
    }
}
