<?php namespace Radic\BladeExtensions\Providers;

use Ciconia\Ciconia;
use Ciconia\Extension\Gfm;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Engines\CompilerEngine;
use Radic\BladeExtensions\Compilers\MarkdownCompiler;
use Radic\BladeExtensions\Directives\MarkdownDirective;
use Radic\BladeExtensions\Engines\BladeMarkdownEngine;
use Radic\BladeExtensions\Engines\PhpMarkdownEngine;

/**
 * Class MarkdownServiceProvider
 *
 * @package        Radic\BladeExtensions
 * @version        2.0.0
 * @subpackage     Providers
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2014, Robin Radic - Radic Technologies
 * @link           http://robin.radic.nl/blade-extensions
 *
 */
class MarkdownServiceProvider extends ServiceProvider
{
    /**
     * Boots the services provided.
     *
     * @return void
     */
    public function boot()
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = $this->app;

        /** @var \Illuminate\View\Factory $view */
        $view = $app['view'];

        # Do not register the engine resolvers if defined in config
        if ($app['config']->get('blade-extensions.markdown.views') === false)
        {
            return;
        }

        # Markdown engine
        $view->getEngineResolver()->register(
            'md',
            function () use ($app)
            {
                $compiler = $app['markdown.compiler'];

                return new CompilerEngine($compiler);
            }
        );
        $view->addExtension('md', 'md');

        # Php markdown engine
        $view->getEngineResolver()->register(
            'phpmd',
            function () use ($app)
            {
                $markdown = $app['markdown'];

                return new PhpMarkdownEngine($markdown);
            }
        );
        $view->addExtension('md.php', 'phpmd');

        # Blade markdown engine
        $view->getEngineResolver()->register(
            'blademd',
            function () use ($app)
            {
                $compiler = $app['blade.compiler'];
                $markdown = $app['markdown'];

                return new BladeMarkdownEngine($compiler, $markdown);
            }
        );
        $view->addExtension('md.blade.php', 'blademd');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'markdown',
            function ($app)
            {
                $gfm         = $app['config']->get('blade-extensions.markdown.gfm');
                $ciconia = new Ciconia();
                if($gfm === true)
                {
                    $ciconia->addExtension(new Gfm\FencedCodeBlockExtension());
                    $ciconia->addExtension(new Gfm\TaskListExtension());
                    $ciconia->addExtension(new Gfm\InlineStyleExtension());
                    $ciconia->addExtension(new Gfm\WhiteSpaceExtension());
                    $ciconia->addExtension(new Gfm\TableExtension());
                    $ciconia->addExtension(new Gfm\UrlAutoLinkExtension());
                }
                return $ciconia;
            }
        );

        $this->app->singleton(
            'markdown.compiler',
            function ($app)
            {
                $ciconia     = $app['markdown'];
                $files       = $app['files'];
                $storagePath = $app['config']->get('view.compiled');

                return new MarkdownCompiler($ciconia, $files, $storagePath);
            }
        );

        MarkdownDirective::attach($this->app);
    }

    public function provides()
    {
        return ['markdown', 'markdown.compiler'];
    }
}
