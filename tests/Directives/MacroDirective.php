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

namespace Radic\BladeExtensions\Directives;

class MacroAbstractDirective extends AbstractDirective
{
    protected $pattern = '/(?<!\\w)(\\s*)@NAME(?:\\s*)\\((?:\\s*)[\'"]([\\w\\d]*)[\'"](?:,|)(.*)\\)/';

    protected $replace = '$1<?php echo app("blade.helpers")->$2($3); ?>';
}
