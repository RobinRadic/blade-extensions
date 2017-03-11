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

use Closure;

/**
 * Contains the logic for handling the configured directives and version overrides.
 *
 * @author  Robin Radic
 */
interface DirectiveRegistry
{
    /**
     * isHooked method.
     * @return bool
     */
    public function isHooked();

    /**
     * Set a custom hooker function. This will be called by the hookToCompiler() method.
     *
     * @param string|Closure $hooker
     *
     * @return \Radic\BladeExtensions\Contracts\DirectiveRegistry
     */
    public function setHooker($hooker);

    /**
     * hookToCompiler method.
     */
    public function hookToCompiler();

    /**
     * @return \Illuminate\View\Compilers\BladeCompiler
     */
    public function getCompiler();

    /**
     * Register a directive (or array of directives).
     *
     * @param      string|array         $name
     * @param      null|string|\Closure $handler
     *
     * @return \Radic\BladeExtensions\DirectiveRegistry
     * @internal param bool $override
     */
    public function register($name, $handler = null);

    /**
     * Gets list of all registered directives their name.
     *
     * @return array
     */
    public function getNames();

    /**
     * Get a registered directive by name.
     *
     * @param $name
     *
     * @return mixed
     */
    public function get($name);

    /**
     * has method.
     *
     * @param $name
     *
     * @return bool
     */
    public function has($name);

    /**
     * Call a directive. This will execute the directive using the given parameters.
     *
     * @param       $name
     * @param array $params
     *
     * @return mixed
     */
    public function call($name, $params = []);

    /**
     * Set the versionOverrides value.
     *
     * @param array[] $versionOverrides
     *
     * @return DirectiveRegistry
     */
    public function setVersionOverrides($versionOverrides);
}
