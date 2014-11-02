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
use Radic\BladeExtensions\Directives\PartialFactory;
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

        $this->registerPartialFactory();
	}


    protected function registerPartialFactory()
    {
        $this->app->bindShared('view', function($app)
        {
            // Next we need to grab the engine resolver instance that will be used by the
            // environment. The resolver will be used by an environment to get each of
            // the various engine implementations such as plain PHP or Blade engine.
            $resolver = $app['view.engine.resolver'];
            $finder = $app['view.finder'];
            $env = new PartialFactory($resolver, $finder, $app['events']);

            // We will also set the container instance on this view environment since the
            // view composers may be classes registered in the container, which allows
            // for great testable, flexible composers for the application developer.
            $env->setContainer($app);
            $env->share('app', $app);
            return $env;
        });
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
