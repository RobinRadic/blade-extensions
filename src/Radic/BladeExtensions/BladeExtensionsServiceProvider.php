<?php namespace Radic\BladeExtensions;
/**
 * Part of Radic - Blade Extensions.
 *
 * @package    Blade Extensions
 * @version    1.0.0
 * @author     Robin Radic
 * @license    MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2014, Robin Radic - Radic Technologies
 * @link       http://radic.nl
 */

use Illuminate\Support\ServiceProvider;
use Route;
use View;

class BladeExtensionsServiceProvider extends ServiceProvider {

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
        BladeExtender::attach($this->app);

    }

}
