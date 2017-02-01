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

class EndmacroDirective extends Directive
{
    protected $pattern = '/(?<!\w)(\s*)@NAME\s*\(\s*\${0,1}[\'"\s]*(.*?)[\'"\s]*,\s*([\W\w^]*?)\)\s*$/m';

    protected $replace = '$1<?php }); ?>$2';

}
