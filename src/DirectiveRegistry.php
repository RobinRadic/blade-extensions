<?php
/**
 * Copyright (c) 2016. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2016 (c) Robin Radic
 * @license https://radic.mit-license.org The MIT License
 */

namespace Radic\BladeExtensions;

use Closure;
use Illuminate\Contracts\Container\Container;

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

    protected $container;

    /**
     * DirectiveRegistry constructor.
     *
     * @param \Illuminate\Contracts\Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * Register a directive (or array of directives).
     *
     * @param      string|array         $name
     * @param      null|string|\Closure $handler
     * @param bool                      $override
     *
     * @return static
     * @throws \InvalidArgumentException
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
                $instance = $this->container->make($class);
                $instance->setName($name);
                $this->resolved[$name] = function ($value) use ($name, $instance, $method, $params) {
                    return call_user_func_array([$instance, $method], $params);
                };
            }
        }

        return call_user_func_array($this->resolved[$name], $params);
    }

    protected function isCallableWithAtSign($callback)
    {
        return is_string($callback) && strpos($callback, '@') !== false;
    }
}
