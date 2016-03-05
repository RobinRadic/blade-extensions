<?php
namespace Radic\BladeExtensions\Providers;

use Sebwite\Support\ServiceProvider;

class BladePreviewServiceProvider extends ServiceProvider
{
    protected $commands = [
        // Commands\SomeCommand::class
    ];

    protected $bindings = [

    ];

    protected $singletons = [

    ];

    protected $aliases = [

    ];

    public function boot(){
        $app = parent::boot();

        return $app;
    }

    public function register(){
        $app = parent::register();
        $router = $app->make('router');
        $router->group(['prefix' => 'test/blade', 'namespace' => 'Radic\\BladeExtensions\\']);
        return $app;
    }

}
