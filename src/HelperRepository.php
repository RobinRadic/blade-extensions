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

/**
 * {@inheritdoc}
 */
class HelperRepository implements Contracts\HelperRepository
{
    /**
     * @var array|\ArrayObject<string,object>
     */
    protected $helpers;

    /**
     * HelperRepository constructor.
     */
    public function __construct()
    {
        $this->helpers = [];
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
        return $this->has($key) ? $this->helpers[ $key ] : $default;
    }
}
