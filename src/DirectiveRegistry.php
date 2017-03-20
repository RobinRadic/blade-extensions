<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright 2017 Robin Radic
 * @license https://radic.mit-license.org MIT License
 * @version 7.0.0 Radic\BladeExtensions
 */

namespace Radic\BladeExtensions;

use Closure;
use Illuminate\Contracts\Foundation\Application;
use Radic\BladeExtensions\Directives\DirectiveInterface;
use Radic\BladeExtensions\Exceptions\InvalidDirectiveClassException;
use Radic\BladeExtensions\Helpers\Util;

/**
 * {@inheritdoc}
 */
class DirectiveRegistry implements Contracts\DirectiveRegistry
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
     * @var array|\Radic\BladeExtensions\Directives\AbstractDirective[]
     */
    protected $resolved = [];

    /** @var \Illuminate\Contracts\Foundation\Application */
    protected $app;

    /** @var bool */
    protected $hooked = false;

    /**
     * @var null|string|\Closure
     */
    protected $hooker;

    /**
     * DirectiveRegistry constructor.
     *
     * @param \Illuminate\Contracts\Container\Container|\Illuminate\Contracts\Foundation\Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * {@inheritdoc}
     */
    public function isHooked()
    {
        return $this->hooked;
    }

    /**
     * {@inheritdoc}
     */
    public function setHooker($hooker)
    {
        $this->hooker = $hooker;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function hookToCompiler()
    {
        if (true === $this->hooked) {
            return;
        }
        $this->hooked = true;

        if (null === $this->hooker) {
            foreach ($this->getNames() as $name) {
                $this->getCompiler()->extend(function ($value) use ($name) {
                    return $this->call($name, [$value]);
                });
            }
        } else {
            $this->app->call($this->hooker, [], 'handle');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getCompiler()
    {
        return $this->app[ 'view' ]->getEngineResolver()->resolve('blade')->getCompiler();
    }

    /**
     * {@inheritdoc}
     */
    public function register($name, $handler = null)
    {
        if ($handler === null) {
            foreach ((array) $name as $directiveName => $directiveHandler) {
                $this->register($directiveName, $directiveHandler);
            }
        } elseif ($handler instanceof DirectiveInterface && false === $handler::isCompatible()) {
            return $this;
        } else {
            $this->directives[ $name ] = $handler;
        }

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getNames()
    {
        return array_keys($this->directives);
    }

    /**
     * {@inheritdoc}
     */
    public function get($name)
    {
        return $this->directives[ $name ];
    }

    /**
     * {@inheritdoc}
     */
    public function has($name)
    {
        return array_key_exists($name, $this->directives);
    }

    /**
     * {@inheritdoc}
     * @throws \Radic\BladeExtensions\Exceptions\InvalidDirectiveClassException
     */
    public function call($name, $params = [])
    {
        if (false === array_key_exists($name, $this->resolved)) {
            $handler = $this->get($name);
            if ($handler instanceof Closure) {
                $this->resolved[ $name ] = function ($value) use ($name, $handler) {
                    return call_user_func_array($handler, [$value]);
                };
            } else {
                $class = $this->isCallableWithAtSign($handler) ? explode('@', $handler)[ 0 ] : $handler;
                $method = $this->isCallableWithAtSign($handler) ? explode('@', $handler)[ 1 ] : 'handle';
                $instance = $this->app->make($class);
                if ($instance instanceof DirectiveInterface === false) {
                    throw InvalidDirectiveClassException::forClass($instance);
                }
                $instance->setName($name);
                $this->resolved[ $name ] = function ($value) use ($name, $instance, $method) {
                    return call_user_func_array([$instance, $method], [$value]);
                };
            }
        }

        return call_user_func_array($this->resolved[ $name ], $params);
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
     * {@inheritdoc}
     */
    public function setVersionOverrides($versionOverrides)
    {
        // if used outside of laravel framework (ie with illuminate/views) we ignore the version overrides completely.
        if (false === class_exists('Illuminate\Foundation\Application', false)) {
            return $this;
        }
        foreach ($versionOverrides as $version => $overrides) {
            if (false === Util::isCompatibleVersionConstraint($version)) {
                continue;
            }
            $this->directives = array_filter(array_replace($this->directives, $overrides));
        }

        return $this;
    }
}
