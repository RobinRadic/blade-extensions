<?php
namespace Radic\BladeExtensions\Traits;

use App;
use Config;
use Exception;
use Illuminate\Foundation\Application;
use Illuminate\View\Engines\CompilerEngine;
use Radic\BladeExtensions\Compilers\MarkdownCompiler;
use Radic\BladeExtensions\Directives\AssignmentDirectives;
use Radic\BladeExtensions\Directives\DebugDirectives;
use Radic\BladeExtensions\Directives\ForeachDirectives;
use Radic\BladeExtensions\Directives\MacroDirectives;
use Radic\BladeExtensions\Directives\MarkdownDirectives;
use Radic\BladeExtensions\Directives\PartialDirectives;
use Radic\BladeExtensions\Directives\WidgetDirectives;
use Radic\BladeExtensions\Engines\BladeMarkdownEngine;
use Radic\BladeExtensions\Engines\PhpMarkdownEngine;
use Radic\BladeExtensions\Helpers\Sections;
use Radic\BladeExtensions\Renderers\BladeStringRenderer;
use Radic\BladeExtensions\Widgets\Factory;

/**
 * This is the BladeProviderTrait.
 *
 * @package        Radic\BladeExtensions
 * @version        1.0.0
 * @author         Robin Radic
 * @license        MIT License
 * @copyright      2015, Robin Radic
 * @link           https://github.com/robinradic
 * @property-read \Illuminate\Foundation\Application $app
 */
trait BladeProviderTrait
{
    protected function registerBlade()
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = $this->app;

        $config = $app->make('config');
        AssignmentDirectives::attach($app);
        DebugDirectives::attach($app);
        ForeachDirectives::attach($app);
        PartialDirectives::attach($app);

        # Optional macro directives
        if ( array_key_exists('form', App::getBindings()) )
        {
            MacroDirectives::attach($app);
        }

        # Optional markdown compiler, engines and directives
        if ( $config->get('blade_extensions.markdown.enabled') )
        {
            if ( ! class_exists($config->get('blade_extensions.markdown.renderer')) )
            {
                throw new Exception('The configured markdown renderer class does not exist');
            }
            $this->registerMarkdown();
            #$me = $this;
            $app->booting(function() {
                $this->bootMarkdown();
            });
            #$app->register('Radic\BladeExtensions\Providers\MarkdownServiceProvider');
        }


        $this->app->singleton('blade.string', function (Application $app)
        {
            return new BladeStringRenderer($app->make('blade.compiler'), $app->make('files'));
        });
    }

    protected function bootMarkdown()
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = $this->app;

        /** @var \Illuminate\View\Factory $view */
        $view = $app[ 'view' ];

        # Markdown engine
        $view->getEngineResolver()->register('md', function () use ($app)
        {
            $compiler = $app[ 'markdown.compiler' ];

            return new CompilerEngine($compiler);
        });
        $view->addExtension('md', 'md');

        # Php markdown engine
        $view->getEngineResolver()->register('phpmd', function () use ($app)
        {
            $markdown = $app[ 'markdown' ];

            return new PhpMarkdownEngine($markdown);
        });
        $view->addExtension('md.php', 'phpmd');

        # Blade markdown engine
        $view->getEngineResolver()->register('blademd', function () use ($app)
        {
            $compiler = $app[ 'blade.compiler' ];
            $markdown = $app[ 'markdown' ];

            return new BladeMarkdownEngine($compiler, $markdown);
        });
        $view->addExtension('md.blade.php', 'blademd');
    }


    /** {@inheritdoc} */
    protected function registerMarkdown()
    {
        $this->app->bind('Radic\BladeExtensions\Contracts\MarkdownRenderer', Config::get('blade_extensions.markdown.renderer'));
        $this->app->singleton('markdown', function ($app)
        {
            return $this->app->make('Radic\BladeExtensions\Contracts\MarkdownRenderer');
        });

        $this->app->singleton('markdown.compiler', function ($app)
        {
            $markdownRenderer = $app['markdown'];
            $files            = $app['files'];
            $storagePath      = Config::get('view.compiled');

            return new MarkdownCompiler($markdownRenderer, $files, $storagePath);
        });

        MarkdownDirectives::attach($this->app);
    }



}
