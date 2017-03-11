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
 * Provides 'features' methods that are usefull when working with Blade templates.
 *
 * @author  Robin Radic
 */
interface BladeExtensions
{
    /**
     * Compile blade syntax to string.
     *
     * @api
     *
     * @param string $string String with blade syntax to compile
     * @param array  $vars   Optional variables
     *
     * @return string
     */
    public function compileString($string, array $vars = []);

    /**
     * pushToStack method.
     *
     * @api
     *
     * @param string          $stackName   The name of the stack
     * @param string|string[] $targetViews The view which contains the stack
     * @param string|\Closure $content     the content to push
     *
     * @return $this
     */
    public function pushToStack($stackName, $targetViews, $content);
}
