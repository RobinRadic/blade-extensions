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

class UnsetAbstractDirective extends AbstractDirective
{
    protected $pattern = '/(?<!\\w)(\\s*)@NAME(?:\\s*)\\((?:\\s*)(?:\\$|(?:\'|\\"|))(.*?)(?:\'|\\"|)(?:\\s*)\\)/';

    protected $replace = '$1<?php unset(\$$2); ?>';
}
