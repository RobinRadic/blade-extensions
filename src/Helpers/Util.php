<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright 2017 Robin Radic
 * @license   https://radic.mit-license.org MIT License
 * @version   7.0.0 Radic\BladeExtensions
 */

namespace Radic\BladeExtensions\Helpers;

use Composer\Semver\Semver;

/**
 * Utility helper class.
 *
 * @author  Robin Radic
 */
class Util
{
    /**
     * Returns the Laravel application version.
     *
     * @return string
     */
    public static function getLaravelVersion()
    {
        return preg_split('/\s/', \Illuminate\Foundation\Application::VERSION)[ 0 ];
    }

    /**
     * Checks if the given version constraint is compatible with the current laravel version.
     *
     * @param string $version The version constraint
     *
     * @return bool
     */
    public static function isCompatibleVersionConstraint($version)
    {
        return Semver::satisfies(static::getLaravelVersion(), $version);
    }
}
