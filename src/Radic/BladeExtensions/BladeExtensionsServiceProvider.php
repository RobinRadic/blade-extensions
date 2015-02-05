<?php namespace Radic\BladeExtensions;

/**
 * Part of Radic - Blade Extensions.
 *
 * @package        Blade Extensions
 * @version        1.2.0
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2014, Robin Radic - Radic Technologies
 * @link           http://radic.nl
 */

use Illuminate\Support\ServiceProvider;
use Radic\BladeExtensions\Directives\ForeachDirective;
use Radic\BladeExtensions\Directives\MacroDirective;
use Radic\BladeExtensions\Directives\PartialDirective;
use Radic\BladeExtensions\Directives\VariablesDirective;

class BladeExtensionsServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->package('radic/blade-extensions', 'radic/blade-extensions');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array();
    }

    /**
     * Boots the services provided. Attaches the blade extensions to the current Application's - ViewEnvironment
     *
     * @todo remove test-blade route/view for stable release
     * @return void
     */
    public function boot()
    {
        //VariablesDirective::attach($this->app);
       // MacroDirective::attach($this->app);
       // ForeachDirective::attach($this->app);
       // PartialDirective::attach($this->app);

        $this->attach(new VariablesDirective);
        $this->attach(new ForeachDirective);

    }


    public $blacklist = [];

    public function attach($class)
    {
        $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();
        $app = $this->app;
        foreach (get_class_methods($class) as $method) {
            if ($method == 'attach') {
                continue;
            }
            if (is_array($class->blacklist) && in_array($method, $class->blacklist)) {
                continue;
            }

            $blade->extend(
                function ($value) use ($app, $class, $blade, $method) {
                    return $class->$method($value, $app, $blade);
                }
            );
        }
    }
}
