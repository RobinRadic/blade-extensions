<?php namespace Radic\Tests\BladeExtensions;

use Mockery as m;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 * @group blade-extensions
 */
class MarkdownViewsTest extends TestCase
{

    public function testMarkdownViews()
    {
        $this->loadViewTesting();
        $this->registerServiceProvider();
        $out = $this->view()->make('markdown.markdown')->render();
        $this->assertEquals('<h1>header</h1>', $out);
    }
    public function testMarkdownViews2()
    {
        $this->loadViewTesting();
        $this->registerServiceProvider();
        $out = $this->view()->make('markdown.markdown2')->render();
        $this->assertEquals('<h1>header</h1>', $out);
    }
    public function testMarkdownViews3()
    {
        $this->loadViewTesting();
        $this->registerServiceProvider();
        $out = $this->view()->make('markdown/markdown3')->render();
        $this->assertEquals('<h1>header</h1>', $out);
    }
}
