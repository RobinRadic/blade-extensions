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

namespace Radic\Tests\BladeExtensions\Directives;

use Radic\Tests\BladeExtensions\DirectiveTestCase;

class MarkdownDirectiveTest extends DirectiveTestCase
{
    protected function getDirectiveClass()
    {
        return 'Radic\BladeExtensions\Directives\MarkdownDirective';
    }
}
