<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2017 (c) Robin Radic
 * @license https://radic.mit-license.org The MIT License
 */

namespace Radic\BladeExtensions;

use Closure;
use Illuminate\Contracts\Foundation\Application;

/**
 * The DirectiveRegistry contains all BladeExtension's directives to be used when compiling views, including the version overrides.
 *
 * @author         Robin Radic
 * @copyright      Copyright (c) 2017, Robin Radic. All rights reserved
 */
class DirectiveRegistry
{
    /**
     * The registered directives.
     *
     * @var array
     */
    protected $directives = [];

    /**
     * The override directives.
     *
     * @var array
     */
    protected $overrides = [];

    /**
     * @var array|\Radic\BladeExtensions\Directives\Directive[]
     */
    protected $resolved = [];

    /** @var \Illuminate\Contracts\Foundation\Application */
    protected $app;

    /** @var bool */
    protected $hooked = false;

    /**
     * @var string|\Closure
     */
    protected $customModeHandler;

    /** @var string */
    protected $mode = 'auto';

    /**
     * @var \Illuminate\View\Compilers\Compiler|\Illuminate\View\Compilers\BladeCompiler
     */
    protected $compiler;

    /**
     * DirectiveRegistry constructor.
     *
     * @param \Illuminate\Contracts\Container\Container $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * hookToCompiler method.
     */
    public function hookToCompiler()
    {
        if (true === $this->hooked) {
            return;
        }
        $this->hooked = true;
        if ($this->mode === 'auto') {
            foreach ($this->getNames() as $name) {
                $this->getCompiler()->extend(function ($value) use ($name) {
                    return $this->call($name, [$value]);
                });
            }
        } elseif ($this->mode === 'custom') {
            if (null === $this->customModeHandler) {
                throw new \RuntimeException('[Custom Mode Handler Not Set]');
            }
            $this->app->call($this->customModeHandler, [], 'handle');
        }
    }

    /**
     * @return \Illuminate\View\Compilers\BladeCompiler
     */
    public function getCompiler()
    {
        return $this->compiler ?: $this->compiler = $this->app->make('view')->getEngineResolver()->resolve('blade')->getCompiler();
    }

    /**
     * Register a directive (or array of directives).
     *
     * @param      string|array         $name
     * @param      null|string|\Closure $handler
     * @param bool                      $override
     *
     * @return \Radic\BladeExtensions\DirectiveRegistry
     */
    public function register($name, $handler = null, $override = false)
    {
        if ($handler === null) {
            foreach ((array) $name as $directiveName => $directiveHandler) {
                $this->register($directiveName, $directiveHandler);
            }
        } else {
            if ((true === $override && true === $this->has($name)) || false === $this->has($name)) {
                $this->directives[$name] = $handler;
            }
        }

        return $this;
    }

    /**
     * Gets list of all registered directives their name.
     *
     * @return array
     */
    public function getNames()
    {
        return array_keys($this->directives);
    }

    /**
     * Get a registered directive by name.
     *
     * @param $name
     *
     * @return mixed
     */
    public function get($name)
    {
        return $this->directives[$name];
    }

    /**
     * has method.
     *
     * @param $name
     *
     * @return bool
     */
    public function has($name)
    {
        return array_key_exists($name, $this->directives);
    }

    /**
     * Set the versionOverrides value.
     *
     * @param array $versionOverrides
     *
     * @return DirectiveRegistry
     */
    public function setVersionOverrides($versionOverrides)
    {
        // if used outside of laravel framework (ie with illuminate/views) we ignore the version overrides completely.
        if (false === class_exists('Illuminate\Foundation\Application', false)) {
            return;
        }
        list($laravelMajor, $laravelMinor) = explode('.', \Illuminate\Foundation\Application::VERSION);
        foreach ($versionOverrides as $version => $overrides) {
            list($major, $minor) = explode('_', $version);
            if ($minor !== $laravelMinor || $major !== $laravelMajor) {
                continue;
            }
            $this->overrides = $overrides;
        }

        return $this;
    }

    /**
     * Call a directive. This will execute the directive using the given parameters.
     *
     * @param       $name
     * @param array $params
     *
     * @return mixed
     */
    public function call($name, $params = [])
    {
        if (false === array_key_exists($name, $this->resolved)) {
            $handler = $this->get($name);
            if ($handler instanceof Closure) {
                $this->resolved[$name] = function ($value) use ($name, $handler, $params) {
                    return call_user_func_array($handler, $params);
                };
            } else {
                $class = $this->isCallableWithAtSign($handler) ? explode('@', $handler)[0] : $handler;
                $method = $this->isCallableWithAtSign($handler) ? explode('@', $handler)[1] : 'handle';
                $instance = $this->app->make($class);
                $instance->setName($name);
                $this->resolved[$name] = function ($value) use ($name, $instance, $method, $params) {
                    return call_user_func_array([$instance, $method], $params);
                };
            }
        }

        return call_user_func_array($this->resolved[$name], $params);
    }

    /**
     * isCallableWithAtSign method.
     *
     * @param $callback
     *
     * @return bool
     */
    protected function isCallableWithAtSign($callback)
    {
        return is_string($callback) && strpos($callback, '@') !== false;
    }

    /**
     * setMode method.
     *
     * @param $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    /**
     * Set the customModeHandler value.
     *
     * @param \Closure|string $customModeHandler
     *
     * @return DirectiveRegistry
     */
    public function setCustomModeHandler($customModeHandler)
    {
        $this->customModeHandler = $customModeHandler;

        return $this;
    }
}
