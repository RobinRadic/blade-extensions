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
 * Time: 11:33 AM
 */

namespace Radic\BladeExtensions\Helpers;


trait BladeMatchers
{

    /**
     * Get the regular expression for a generic Blade function.
     *
     * @param  string $function
     *
     * @return string
     */
    public function createMatcher($function)
    {
        return '/(?<!\w)(\s*)@' . $function . '(\s*\(.*\))/';
    }

    /**
     * Get the regular expression for a generic Blade function.
     *
     * @param  string $function
     *
     * @return string
     */
    public function createOpenMatcher($function)
    {
        return '/(?<!\w)(\s*)@' . $function . '(\s*\(.*)\)/';
    }

    /**
     * Create a plain Blade matcher.
     *
     * @param  string $function
     *
     * @return string
     */
    public function createPlainMatcher($function)
    {
        return '/(?<!\w)(\s*)@' . $function . '(\s*)/';
    }
}
