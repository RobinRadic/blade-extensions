<?php namespace Radic\BladeExtensions;

use Illuminate\Support\ServiceProvider;
use Radic\BladeExtensions\Directives\ForeachDirective;
use Radic\BladeExtensions\Directives\MacroDirective;
use Radic\BladeExtensions\Directives\PartialDirective;
use Radic\BladeExtensions\Directives\VariablesDirective;

/**
 * Class BladeExtensionsServiceProvider
 *
 * @package        Radic\BladeExtensions
 * @version        1.3.0
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2014, Robin Radic - Radic Technologies
 * @link           http://robin.radic.nl/blade-extensions
 *
 */
class BladeExtensionsServiceProvider extends ServiceProvider
{

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Boots the services provided. Attaches the blade extensions to the current Application's - ViewEnvironment
     *
     * @return void
     */
    public function boot()
    {
        $configPath = __DIR__ . '/../../config/blade-extensions.php';
        $this->publishes([$configPath => config_path('blade-extensions.php')], 'config');

        VariablesDirective::attach($this->app);
        MacroDirective::attach($this->app);
        ForeachDirective::attach($this->app);
        PartialDirective::attach($this->app);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $configPath = __DIR__ . '/../../config/blade-extensions.php';
        $this->mergeConfigFrom($configPath, 'blade-extensions');
    }
}
