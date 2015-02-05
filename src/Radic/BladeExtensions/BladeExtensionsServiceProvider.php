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
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->package('radic/blade-extensions', 'radic/blade-extensions');
    }

    /**
     * Boots the services provided. Attaches the blade extensions to the current Application's - ViewEnvironment
     *
     * @todo remove test-blade route/view for stable release
     * @return void
     */
    public function boot()
    {
        VariablesDirective::attach($this->app);
        MacroDirective::attach($this->app);
        ForeachDirective::attach($this->app);
        PartialDirective::attach($this->app);
    }
}
