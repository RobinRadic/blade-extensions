<?php
/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 8/7/16
 * Time: 1:40 AM
 */

namespace Radic\BladeExtensions\Seven;


use Illuminate\Support\ServiceProvider;

class Provider extends ServiceProvider
{

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config.php', 'blade-extensions');

        $this->app->singleton('blade-extensions', function ($app) {
            $config  = $app[ 'config' ][ 'blade-extensions' ];
            $factory = new Factory($app, $app[ 'blade-extensions.directives' ]);
            $factory->setMode($config[ 'mode' ]);
            return $factory;
        });

        $this->app->singleton('blade-extensions.directives', function ($app) {
            $directives = new DirectiveRegistry($app);
            $directives->set($app[ 'config' ]->get('blade-extensions.directives', [ ]));
            return $directives;
        });

        $this->app->booting(function ($app) {
            /** @var Factory $be */
            $be = $app[ 'blade-extensions' ];
            $m  = $be->getMode();
        });
    }
}
