<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright 2017 Robin Radic
 * @license https://radic.mit-license.org MIT License
 * @version 7.0.0
 */
namespace Radic\BladeExtensions\Helpers;

/**
 * This is the class BladeMatchers.
 *
 * @package Radic\BladeExtensions\Helpers
 * @author  Robin Radic
 */
trait BladeMatchers
{
    /**
     * Get the regular expression for a generic Blade function.
     *
     * @param  string $function
     *
     * @return string
     */
    public function createMatcher($function = 'NAME')
    {
        return '/(?<!\w)(\s*)@'.$function.'(\s*\(.*\))/';
    }

    /**
     * Get the regular expression for a generic Blade function.
     *
     * @param  string $function
     *
     * @return string
     */
    public function createOpenMatcher($function = 'NAME')
    {
        return '/(?<!\w)(\s*)@'.$function.'(\s*\(.*)\)/';
    }

    /**
     * Create a plain Blade matcher.
     *
     * @param  string $function
     *
     * @return string
     */
    public function createPlainMatcher($function = 'NAME')
    {
        return '/(?<!\w)(\s*)@'.$function.'(\s*)/';
    }
}
