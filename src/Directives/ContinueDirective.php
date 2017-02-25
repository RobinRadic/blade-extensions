<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2017 (c) Robin Radic
 * @license https://radic.mit-license.org The MIT License
 */

namespace Radic\BladeExtensions\Directives;

class ContinueDirective extends Directive
{
    public static $compatibility = '5.0.*|5.1.*';

    protected $replace = '$1<?php app("blade-extensions.helpers")->get("loop")->looped(); continue; ?>$2';
}
