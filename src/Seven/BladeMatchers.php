<?php
/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 8/7/16
 * Time: 11:33 AM
 */

namespace Radic\BladeExtensions\Seven;


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
