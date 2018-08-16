<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright 2017 Robin Radic
 * @license   https://radic.mit-license.org MIT License
 *
 * @version   7.0.0 Radic\BladeExtensions
 */

namespace Radic\BladeExtensions;

use Illuminate\Support\ServiceProvider;
use Radic\BladeExtensions\Directives\MarkdownDirective;
use Radic\BladeExtensions\Helpers\DumpHelper;
use Radic\BladeExtensions\Helpers\Embed\EmbedHelper;
use Radic\BladeExtensions\Helpers\Loop\LoopHelper;
use Radic\BladeExtensions\Helpers\Markdown\CebeMarkdownParser;
use Radic\BladeExtensions\Helpers\Markdown\MarkdownHelper;
use Radic\BladeExtensions\Helpers\Markdown\MarkdownParserInterface;
use Radic\BladeExtensions\Helpers\Minifier\MinifierHelper;

/**
 * This is the class BladeExtensionsServiceProvider.
 *
 * @author  Robin Radic
 */
class BladeExtensionsServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../config/blade-extensions.php' => config_path('blade-extensions.php'),
        ], 'config');
    }

    /**
     * Register the service provider.
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/blade-extensions.php', 'blade-extensions');

        $this->registerDirectiveRegistry();

        $this->registerHelperRepository();

        $this->registerBladeExtensions();

        $this->registerAliases();

        $this->registerContextualBindings();

        $this->app->booted(function ($app) {
            $app['blade-extensions.directives']->hookToCompiler();
        });
    }

    protected function registerBladeExtensions()
    {
        $this->app->singleton('blade-extensions', function ($app) {
            return new BladeExtensions($app['blade-extensions.directives'], $app['blade-extensions.helpers']);
        });
    }

    protected function registerDirectiveRegistry()
    {
        $this->app->singleton('blade-extensions.directives', function ($app) {
            $directives = new DirectiveRegistry($app);
            $directives->register($app['config']['blade-extensions.directives']);
            if ($this->app->environment() === 'testing') {
                $directives->register($app['config']->get('blade-extensions.optional', []));
            }
            $directives->setVersionOverrides($app['config']['blade-extensions.version_overrides']);

            return $directives;
        });
    }

    protected function registerHelperRepository()
    {
        $this->app->singleton('blade-extensions.helpers', function ($app) {
            $helpers = new HelperRepository($app);
            $helpers->register('minifier', MinifierHelper::class);
            $helpers->register('markdown', MarkdownHelper::class);
            $helpers->register('embed', EmbedHelper::class);
            $helpers->register('loop', LoopHelper::class);
            $helpers->register('dump', DumpHelper::class);
            return $helpers;
        });
    }

    protected function registerAliases()
    {
        $aliases = [
            'blade-extensions' => [BladeExtensions::class, Contracts\BladeExtensions::class],
            'blade-extensions.directives' => [DirectiveRegistry::class, Contracts\DirectiveRegistry::class],
            'blade-extensions.helpers' => [HelperRepository::class, Contracts\HelperRepository::class],
        ];

        foreach ($aliases as $key => $_aliases) {
            foreach ($_aliases as $alias) {
                $this->app->alias($key, $alias);
            }
        }
    }

    /**
     * registerContextualBindings method.
     */
    protected function registerContextualBindings()
    {
        $this->app
            ->when(MarkdownDirective::class)
            ->needs(MarkdownParserInterface::class)
            ->give(CebeMarkdownParser::class);
    }
}
