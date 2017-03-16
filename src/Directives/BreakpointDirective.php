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

namespace Radic\BladeExtensions\Directives;

/**
 * This is the class BreakpointDirective.
 *
 * @blade-directive @breakpoint
 * @author  Robin Radic
 */
class BreakpointDirective extends AbstractDirective
{
    public static $functionName = 'xdebug_break';

    protected $replace = '$1<?php if(function_exists("FUNCTION_NAME")){ FUNCTION_NAME(); } ?>$2';

    /**
     * {@inheritdoc}
     *
     * @see BreakpointAbstractDirective::$functionName The function name to use to invoke a breakpoint
     */
    public function getReplace()
    {
        return preg_replace('/FUNCTION_NAME/', static::$functionName, parent::getReplace());
    }
}
