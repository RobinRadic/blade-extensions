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

namespace Radic\BladeExtensions\Contracts;

/**
 * Used for storing instances of helper classes.
 *
 * @author  Robin Radic
 */
interface HelperRepository
{
    /**
     * Put a helper instance in the repository.
     *
     * @param string $key      The accessor key
     * @param object $instance The class instance
     *
     * @return $this
     */
    public function put($key, $instance);

    /**
     * Check if a instance exists in the repository.
     *
     * @param string $key The accessor key
     *
     * @return bool
     */
    public function has($key);

    /**
     * Get a helper instance from the repository.
     *
     * @param     string $key The accessor key
     * @param null $default The
     *
     * @return mixed
     */
    public function get($key, $default = null);
}
