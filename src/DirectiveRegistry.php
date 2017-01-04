<?php
/**
 * Copyright (c) 2016. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2016 (c) Robin Radic
 * @license https://radic.mit-license.org The MIT License
 */

/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 8/7/16
 * Time: 5:24 AM
 */

namespace Radic\BladeExtensions;


use Closure;
use Illuminate\Contracts\Foundation\Application;

class DirectiveRegistry
{
    protected $directives = [];

    protected $overrides = [];

    protected $app;


    /**
     * DirectiveRegistry constructor.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Radic\BladeExtensions\Seven\Factory         $factory
     */
    public function __construct(Application $app)
    {
        $this->app     = $app;
    }

    /**
     * Set the versionOverrides value
     *
     * @param array $versionOverrides
     *
     * @return DirectiveRegistry
     */
    public function setVersionOverrides($versionOverrides)
    {
        // if used outside of laravel framework (ie with illuminate/views) we ignore the version overrides completely.
        if(false === class_exists('Illuminate\Foundation\Application', false)){
            return;
        }
        list($laravelMajor, $laravelMinor) = explode('.', \Illuminate\Foundation\Application::VERSION);
        foreach($versionOverrides as $version => $overrides){
            list($major, $minor) = explode('_', $version);
            if($minor !== $laravelMinor || $major !== $laravelMajor){
                continue;
            }
            $this->overrides = $overrides;
        }
        return $this;
    }




    public function has($name)
    {
        return array_key_exists($name, $this->directives);
    }

    public function get($name)
    {
        return $this->directives[ $name ];
    }

    /**
     * @param      string|array         $name
     * @param      null|string|\Closure $handler
     * @param bool                      $override
     *
     * @return static
     * @throws \InvalidArgumentException
     */
    public function set($name, $handler = null, $override = false)
    {
        if ( $handler === null ) {
            foreach ( (array)$name as $directiveName => $directiveHandler ) {
                $this->set($directiveName, $directiveHandler);
            }
        } else {
            if ( (true === $override && true === $this->has($name)) || false === $this->has($name) ) {
                $this->directives[ $name ] = $handler;
            }
        }

        return $this;
    }

    public function getNames()
    {
        return array_keys($this->directives);
    }

    protected $resolved = [];

    public function call($name, $params = [])
    {
        if ( false === array_key_exists($name, $this->resolved) ) {
            $handler = $this->get($name);
            if ( $handler instanceof Closure ) {
                $this->resolved[ $name ] = function ($value) use ($name, $handler, $params) {
                    return call_user_func_array($handler, $params);
                };
            } else {
                $class    = $this->isCallableWithAtSign($handler) ? explode('@', $handler)[ 0 ] : $handler;
                $method   = $this->isCallableWithAtSign($handler) ? explode('@', $handler)[ 1 ] : 'handle';
                $instance = $this->app->make($class);
                $instance->setName($name);
                $this->resolved[ $name ] = function ($value) use ($name, $instance, $method, $params) {
                    return call_user_func_array([ $instance, $method ], $params);
                };
            }
        }

        return call_user_func_array($this->resolved[ $name ], $params);
    }

    protected function isCallableWithAtSign($callback)
    {
        return is_string($callback) && strpos($callback, '@') !== false;
    }


}
