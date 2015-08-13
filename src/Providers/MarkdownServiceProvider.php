<?php
/**
 * Class MarkdownServiceProvider
 */
namespace Radic\BladeExtensions\Providers;

use Ciconia\Extension\Gfm;
use Config;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Engines\CompilerEngine;
use Radic\BladeExtensions\Compilers\MarkdownCompiler;
use Radic\BladeExtensions\Directives\MarkdownDirectives;
use Radic\BladeExtensions\Engines\BladeMarkdownEngine;
use Radic\BladeExtensions\Engines\PhpMarkdownEngine;

/**
 * Class MarkdownServiceProvider
 *
 * @package        Radic\BladeExtensions
 * @subpackage     Providers
 * @version        2.1.0
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright      2011-2015, Robin Radic - Radic Technologies
 * @link           http://robin.radic.nl/blade-extensions
 *
 */
class MarkdownServiceProvider extends ServiceProvider
{
    /** {@inheritdoc} */
    public function boot()
    {
        # Do not register the engine resolvers if defined in config
        if (Config::get('blade_extensions.markdown.views') !== true) {
            return;
        }


        /** @var \Illuminate\Foundation\Application $app */
        $app = $this->app;

        /** @var \Illuminate\View\Factory $view */
        $view = $app['view'];

        # Markdown engine
        $view->getEngineResolver()->register('md', function () use ($app) {
        
            $compiler = $app['markdown.compiler'];

            return new CompilerEngine($compiler);
        });
        $view->addExtension('md', 'md');

        # Php markdown engine
        $view->getEngineResolver()->register('phpmd', function () use ($app) {
        
            $markdown = $app['markdown'];

            return new PhpMarkdownEngine($markdown);
        });
        $view->addExtension('md.php', 'phpmd');

        # Blade markdown engine
        $view->getEngineResolver()->register('blademd', function () use ($app) {
        
            $compiler = $app['blade.compiler'];
            $markdown = $app['markdown'];

            return new BladeMarkdownEngine($compiler, $markdown);
        });
        $view->addExtension('md.blade.php', 'blademd');
    }

    /** {@inheritdoc} */
    public function register()
    {
        $this->app->bind('Radic\BladeExtensions\Contracts\MarkdownRenderer', Config::get('blade_extensions.markdown.renderer'));
        $this->app->singleton('markdown', function ($app) {
        
            return $this->app->make('Radic\BladeExtensions\Contracts\MarkdownRenderer');
        });

        $this->app->singleton('markdown.compiler', function ($app) {
        
            $markdownRenderer = $app['markdown'];
            $files            = $app['files'];
            $storagePath      = Config::get('view.compiled');

            return new MarkdownCompiler($markdownRenderer, $files, $storagePath);
        });

        MarkdownDirectives::attach($this->app);
    }

    /** {@inheritdoc} */
    public function provides()
    {
        return ['markdown', 'markdown.compiler'];
    }
}
