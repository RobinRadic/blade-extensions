<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2017 (c) Robin Radic
 * @license https://radic.mit-license.org The MIT License
 */

namespace Radic\Tests\BladeExtensions\Directives;

use Radic\Tests\BladeExtensions\DirectivesTestCase;

class EndspacelessDirectiveTest extends DirectivesTestCase
{
    protected function getDirectiveClass()
    {
        return 'Radic\BladeExtensions\Directives\EndspacelessDirective';
    }

}
