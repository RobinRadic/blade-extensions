<?php
/**
 * A laravel service provider to register the class into the the IoC container
 */
namespace Radic\BladeExtensions;

use Caffeinated\Beverage\ServiceProvider;
use Exception;
use Radic\BladeExtensions\Directives\AssignmentDirectives;
use Radic\BladeExtensions\Directives\DebugDirectives;
use Radic\BladeExtensions\Directives\EmbeddingDirectives;
use Radic\BladeExtensions\Directives\ForeachDirectives;
use Radic\BladeExtensions\Directives\MacroDirectives;
use Radic\BladeExtensions\Directives\MinifyDirectives;
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

    protected $providers = [ \Caffeinated\Beverage\BeverageServiceProvider::class ];

    protected $provides = [ 'blade.helpers', 'blade.string' ];

    protected $bindings = [
        'blade.string' => BladeStringRenderer::class
    ];

    protected $singletons = [
        'blade.helpers' => Helpers\HelperRepository::class
    ];

    /** {@inheritDoc} */
    public function boot()
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = parent::boot();
        if ( array_key_exists('form', $app->getBindings()) )
        {
            MacroDirectives::attach($app);
        }
    }

    /** {@inheritDoc} */
    public function register()
    {
        /** @var \Illuminate\Foundation\Application $app */
        $app = parent::register();

        $config = $app->make('config');

        AssignmentDirectives::attach($app);
        DebugDirectives::attach($app);
        ForeachDirectives::attach($app);
        EmbeddingDirectives::attach($app);

        # Optional markdown compiler, engines and directives
        if ( $config->get('blade_extensions.markdown.enabled') )
        {
            if ( ! class_exists($config->get('blade_extensions.markdown.renderer')) )
            {
                throw new Exception('The configured markdown renderer class does not exist');
            }
            $app->register(\Radic\BladeExtensions\Providers\MarkdownServiceProvider::class);
        }

        # Optional minify directives
        if ( class_exists('MatthiasMullie\Minify\CSS') )
        {
            MinifyDirectives::attach($app);
        }
    }


}
