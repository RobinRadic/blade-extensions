<?php
/**
 * Copyright (c) 2016. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2016 (c) Robin Radic
 * @license https://radic.mit-license.org The MIT License
 */

namespace Radic\Tests\BladeExtensions\Directives;

use Radic\Tests\BladeExtensions\DirectivesTestCase;

class BreakDirectiveTest extends DirectivesTestCase
{
    /**
     * getDirectiveClass method
     * @return string
     */
    protected function getDirectiveClass()
    {
        return 'Radic\BladeExtensions\Directives\BreakDirective';
    }

    public function testReplace()
    {
        $this->assertEquals($this->getDirective()->setName('break')->handle('@break'), '<?php break; ?>');

    }
}
