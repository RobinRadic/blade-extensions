<?php
/**
 * Copyright (c) 2016. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2016 (c) Robin Radic
 * @license https://radic.mit-license.org The MIT License
 */

namespace Radic\BladeExtensions\Directives;

class BreakpointDirective extends Directive
{
    protected $replace = '$1<?php if(function_exists("xdebug_break")){ xdebug_break(); } ?>$2';
}
