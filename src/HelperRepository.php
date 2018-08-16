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

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Traits\Macroable;

/**
 * {@inheritdoc}
 */
class HelperRepository implements Contracts\HelperRepository
{
    use Macroable;

    /**
     * @var array|\ArrayObject<string,object>
     */
    protected $helpers;

    /** @var \Illuminate\Contracts\Container\Container */
    protected $container;

    protected $registered;

    /**
     * HelperRepository constructor.
     */
    public function __construct(Container $container)
    {
        $this->helpers    = [];
        $this->registered = [];
        $this->container  = $container;
    }

    /**
     * {@inheritdoc}
     */
    public function put($key, $instance)
    {
        $this->helpers[ $key ] = $instance;
    }

    /**
     * {@inheritdoc}
     */
    public function has($key)
    {
        return isset($this->helpers[ $key ]);
    }

    /**
     * {@inheritdoc}
     */
    public function get($key, $default = null)
    {
        if ( ! $this->has($key)) {
            if ( ! $this->hasRegistered($key)) {
                return $default;
            }
            $this->put($key, $this->container->make($this->getRegistered($key)));
        }
        return $this->helpers[ $key ];
    }

    public function register($key, $class)
    {
        $this->registered[ $key ] = $class;
    }

    public function hasRegistered($key)
    {
        return isset($this->registered[ $key ]);
    }

    public function getRegistered($key)
    {
        return $this->registered[ $key ];
    }
}
