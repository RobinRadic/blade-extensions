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
 * This is the class EndmarkdownDirective.
 *
 * @author  Robin Radic
 */
class EndmarkdownDirective extends AbstractDirective
{
    protected $replace = "$1\nEOT\n); ?>$2";
}
