<?php namespace Radic\Tests\BladeExtensions\Directives;

use Mockery as M;
use Radic\BladeExtensions\Compilers\MarkdownCompiler;
use Radic\Tests\BladeExtensions\TestCase;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 * @group      blade-extensions
 */
class MarkdownCompilerTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();

        parent::loadViewTesting();
        parent::registerHtml();
        $this->app->config->set('blade_extensions.markdown.views', true);
        parent::registerBlade();
        parent::registerBladeMarkdown();
        $this->app->config->set('blade_extensions.markdown.views', true);
    }

    public function testCompile()
    {
        $renderers = ['Radic\BladeExtensions\Renderers\ParsedownRenderer' => 'Parsedown']; //, 'Radic\BladeExtensions\Renderers\CiconiaRenderer' => 'Ciconia\Ciconia'];

        foreach ($renderers as $class => $renderer) {
            $compiler = $this->getCompiler($class, $renderer);

            $path = __DIR__ . '/../views/markdown/bold.md';
            $this->assertEquals('<h1>header</h1>', $compiler->getRenderer()->render('# header'));
            $compiler->compile($path);
            $this->assertFileExists($compiler->getCompiledPath($path));
        }
    }

    protected function getCompiler($class, $renderer)
    {
        $render = new $renderer;
        $markdown  = new $class($render);
        $files     = $this->app['files'];
        $cachePath = $this->app['path.storage'];

        return new MarkdownCompiler($markdown, $files, $cachePath);
    }

    public function testMarkdownEngine()
    {
       # $this->assertEquals('<h1>header</h1>', $this->view()->make('markdown/test_md')->render());
    }

    public function testPhpMarkdownEngine()
    {
       # $this->assertEquals('<h1>header</h1>', $this->view()->make('markdown/test_phpmd')->render());
    }

    public function testBladeMarkdownEngine()
    {
       # $this->assertEquals('<h1>header</h1>', $this->view()->make('markdown/test_blademd')->render());
    }
}
