<?php
/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 8/7/16
 * Time: 5:24 AM
 */

namespace Radic\BladeExtensions\Seven;


use Closure;
use Illuminate\Contracts\Foundation\Application;

class DirectiveRegistry
{
    protected $directives = [ ];

    protected $app;

    /**
     * DirectiveRegistry constructor.
     *
     * @param $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
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

    protected $resolved = [ ];

    public function call($name, $params = [ ])
    {
        if ( false === array_key_exists($name, $this->resolved) ) {
            $handler = $this->get($name);
            if ( $handler instanceof Closure ) {
                $this->resolved[ $name ] = function ($value) use ($name, $handler, $params) {
                    return call_user_func_array($handler, $params);
                };
            } else {
                $class                   = $this->isCallableWithAtSign($handler) ? explode('@', $handler)[ 0 ] : $handler;
                $method                  = $this->isCallableWithAtSign($handler) ? explode('@', $handler)[ 1 ] : 'handle';
                $instance                = $this->app->make($class);
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
