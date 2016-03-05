<?php
namespace Radic\BladeExtensions\Providers;

use Illuminate\Contracts\Foundation\Application;
use Sebwite\Support\ServiceProvider;

abstract class BladeServiceProvider extends ServiceProvider
{

    protected function config($key = null, $default = null)
    {
        $config = $this->app[ 'config' ][ 'blade_extensions' ];
        return $key === null ? $config : data_get($config, $key, $default);
    }

    public function __construct(Application $app)
    {
        parent::__construct($app);
        if ( method_exists($this, 'booting') ) {
            $app->booting(function (Application $app) {
                $this->booting($app);
            });
        }
    }

}
