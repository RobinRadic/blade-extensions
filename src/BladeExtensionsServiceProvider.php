<?php
/**
 * A laravel service provider to register the class into the the IoC container
 */
namespace Radic\BladeExtensions;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Engines\CompilerEngine;
use Radic\BladeExtensions\Compilers\MarkdownCompiler;
use Radic\BladeExtensions\Directives\AssignmentDirectives;
use Radic\BladeExtensions\Directives\DebugDirectives;
use Radic\BladeExtensions\Directives\EmbeddingDirectives;
use Radic\BladeExtensions\Directives\ForeachDirectives;
use Radic\BladeExtensions\Directives\MacroDirectives;
use Radic\BladeExtensions\Directives\MarkdownDirectives;
use Radic\BladeExtensions\Directives\MinifyDirectives;
use Radic\BladeExtensions\Engines\BladeMarkdownEngine;
use Radic\BladeExtensions\Engines\PhpMarkdownEngine;
use Radic\BladeExtensions\Renderers\BladeStringRenderer;


/**
 * A laravel service provider to register the class into the the IoC container
 *
 * @package        Radic\BladeExtensions
 * @version        2.1.0
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright      2011-2015, Robin Radic
 * @link           http://robin.radic.nl/blade-extensions
 *
 */
class BladeExtensionsServiceProvider extends ServiceProvider
{


    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        $provides = [ 'blade.helpers', 'blade.string' ];

        if ( $this->app[ 'config' ][ 'blade_extensions.markdown.enabled' ] ) {
            $provides = array_merge($provides, [ 'markdown', 'markdown.compiler' ]);
        }

        return $provides;
    }


    /** {@inheritDoc} */
    public function boot()
    {
        $configPath  = __DIR__ . '/../config/blade_extensions.php';
        $publishPath = function_exists('config_path') ? config_path('blade_extensions.php') : base_path('config/blade_extensions.php');
        $this->publishes([ $configPath => $publishPath ], 'config');

        if($this->app[ 'config' ]->get('blade_extensions.example_views', false) === true) {
            $viewPath = __DIR__ . '/../resources/views';
            $this->loadViewsFrom($viewPath, 'blade-ext');
            $this->publishes([ $viewPath => resource_path('views/vendor/blade-ext') ], 'views');
        }

        $config = array_dot($this->app[ 'config' ][ 'blade_extensions' ]);
        if ( $config[ 'markdown.enabled' ] ) {
            $view     = $this->app->make('view');
            $compiler = $this->app->make('markdown.compiler');
            $markdown = $this->app->make('markdown');
            $blade    = $this->app->make('blade.compiler');

            $view->getEngineResolver()->register('md', function () use ($compiler) {
                return new CompilerEngine($compiler);
            });
            $view->addExtension('md', 'md');


            $view->getEngineResolver()->register('phpmd', function () use ($markdown) {
                return new PhpMarkdownEngine($markdown);
            });
            $view->addExtension('md.php', 'phpmd');


            $view->getEngineResolver()->register('blademd', function () use ($blade, $markdown) {
                return new BladeMarkdownEngine($blade, $markdown);
            });
            $view->addExtension('md.blade.php', 'blademd');
        }
    }

    /** {@inheritDoc} */
    public function register()
    {
        $configPath = __DIR__ . '/../config/blade_extensions.php';
        $this->mergeConfigFrom($configPath, 'blade_extensions');

        $config = array_dot($this->app[ 'config' ][ 'blade_extensions' ]);

        if ( $config[ 'example_views' ] === true ) {
            $this->viewDirs = [ 'views' => 'blade-ext' ];
        }

        $this->registerHelpers();

        $this->app->bind('blade.string', BladeStringRenderer::class);

        AssignmentDirectives::attach($this->app);
        DebugDirectives::attach($this->app);
        ForeachDirectives::attach($this->app);
        EmbeddingDirectives::attach($this->app);
        MacroDirectives::attach($this->app);
        MinifyDirectives::attach($this->app);

        # Optional markdown compiler, engines and directives
        if ( $config[ 'markdown.enabled' ] ) {
            if ( !class_exists($config[ 'markdown.renderer' ]) ) {
                throw new Exception('The configured markdown renderer class does not exist');
            }


            $this->app->bind('Radic\BladeExtensions\Contracts\MarkdownRenderer', $config[ 'markdown.renderer' ]);
            $this->app->singleton('markdown', function (Application $app) {

                return $app->make('Radic\BladeExtensions\Contracts\MarkdownRenderer');
            });

            $this->app->singleton('markdown.compiler', function (Application $app) {

                $markdownRenderer = $app->make('markdown');
                $files            = $app->make('files');
                $storagePath      = $app[ 'config' ]->get('view.compiled');

                return new MarkdownCompiler($markdownRenderer, $files, $storagePath);
            });

            MarkdownDirectives::attach($this->app);
        }
    }


    protected function registerHelpers()
    {

        $this->app->singleton('blade.helpers', function (Application $app) {

            $helpers = new Helpers\HelperRepository($app);

            $helperClasses = [
                'loop'     => Helpers\LoopFactory::class,
                'embed'    => Helpers\EmbedStacker::class,
                'minifier' => Helpers\Minifier::class,
            ];

            if ( $app[ 'config' ][ 'blade_extensions.markdown.enabled' ] ) {
                $helperClasses[ 'markdown' ] = Helpers\Markdown::class;
            }

            foreach ( $helperClasses as $name => $class ) {
                $helpers->put($name, $app->make($class));
            }

            return $helpers;
        });
    }
}
