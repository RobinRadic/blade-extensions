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
    public function boot()
    {
        $this->app[ 'blade-extensions' ]->hookToCompiler();
    }

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
            $factory = new Factory($app);
            $factory->setMode($config[ 'mode' ]);

            $factory->getDirectives()->set($config[ 'directives' ]);

            $helpers = $factory->getHelpers();
            $helpers->put('loop', $app->build(Helpers\Loop\LoopHelper::class));
            $helpers->put('embed', $app->build(Helpers\Embed\EmbedHelper::class));
            $helpers->put('minifier', $app->build(Helpers\Minifier\MinifierHelper::class));
            $helpers->put('markdown', $app->build(Helpers\Markdown\MarkdownHelper::class));

            return $factory;
        });

        $this->app->bind('blade-extensions.directives', function ($app) {
            return new DirectiveRegistry($app);
        });
        $this->app->bind('blade-extensions.helpers', function ($app) {
            return new HelperRepository($app);
        });
    }
}
