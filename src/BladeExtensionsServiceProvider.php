<?php
/**
 * A laravel service provider to register the class into the the IoC container
 */
namespace Radic\BladeExtensions;

use Sebwite\Support\ServiceProvider;
use Exception;
use Illuminate\Contracts\Foundation\Application;
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

    /** {@inheritDoc} */
    protected $configFiles = [ 'blade_extensions' ];

    /**
     * {@inheritDoc}
     */
    protected $dir = __DIR__;

    protected $providers = [ \Sebwite\Support\SupportServiceProvider::class ];

    protected $provides = [ 'blade.helpers', 'blade.string' ];

    protected $bindings = [
        'blade.string' => BladeStringRenderer::class
    ];


    /** {@inheritDoc} */
    public function boot()
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = parent::boot();

        $config = array_dot($this->app[ 'config' ][ 'blade_extensions' ]);
        if ($config[ 'markdown.enabled' ]) {
            $view     = $app->make('view');
            $compiler = $app->make('markdown.compiler');
            $markdown = $app->make('markdown');
            $blade    = $app->make('blade.compiler');

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
        /** @var \Illuminate\Foundation\Application $app */
        $app = parent::register();

        $config = array_dot($this->app[ 'config' ][ 'blade_extensions' ]);

        if ($config[ 'example_views' ] === true) {
            $this->viewDirs = [ 'views' => 'blade-ext' ];
        }

        $this->registerHelpers();

        AssignmentDirectives::attach($app);
        DebugDirectives::attach($app);
        ForeachDirectives::attach($app);
        EmbeddingDirectives::attach($app);
        MacroDirectives::attach($app);
        MinifyDirectives::attach($app);

        # Optional markdown compiler, engines and directives
        if ($config[ 'markdown.enabled' ]) {
            if (! class_exists($config[ 'markdown.renderer' ])) {
                throw new Exception('The configured markdown renderer class does not exist');
            }


            $app->bind('Radic\BladeExtensions\Contracts\MarkdownRenderer', $config[ 'markdown.renderer' ]);
            $app->singleton('markdown', function (Application $app) {
            
                return $app->make('Radic\BladeExtensions\Contracts\MarkdownRenderer');
            });

            $app->singleton('markdown.compiler', function (Application $app) {
            
                $markdownRenderer = $app->make('markdown');
                $files            = $app->make('files');
                $storagePath      = $app[ 'config' ]->get('view.compiled');

                return new MarkdownCompiler($markdownRenderer, $files, $storagePath);
            });

            MarkdownDirectives::attach($app);
        }
    }

    /**
     * @inheritDoc
     */
    public function provides()
    {
        $p = parent::provides();

        if ($this->app[ 'config' ][ 'blade_extensions.markdown.enabled' ]) {
            $p = array_merge($p, [ 'markdown', 'markdown.compiler' ]);
        }

        return $p;
    }

    protected function registerHelpers()
    {

        $this->app->singleton('blade.helpers', function (Application $app) {
        
            $helpers = new Helpers\HelperRepository($app);

            $helperClasses = [
                'loop'     => Helpers\LoopFactory::class,
                'embed'    => Helpers\EmbedStacker::class,
                'minifier' => Helpers\Minifier::class
            ];

            if ($app[ 'config' ][ 'blade_extensions.markdown.enabled' ]) {
                $helperClasses[ 'markdown' ] = Helpers\Markdown::class;
            }

            foreach ($helperClasses as $name => $class) {
                $helpers->put($name, $app->make($class));
            }

            return $helpers;
        });
    }
}
