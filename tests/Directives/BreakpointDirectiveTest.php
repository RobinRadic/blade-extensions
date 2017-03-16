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

class BreakpointDirectiveTest extends DirectiveTestCase
{
    /**
     * getDirectiveClass method.
     * @return string
     */
    protected function getDirectiveClass()
    {
        return 'Radic\BladeExtensions\Directives\BreakpointDirective';
    }

    /**
     * Test the set directive.
     */
    public function testView()
    {
        $this->assertEquals($this->render('directives.breakpoint'), '');
    }

    public function testReplace()
    {
        $this->assertEquals(
            $this->getDirective()->setName('breakpoint')->handle('@breakpoint'),
            '<?php if(function_exists("xdebug_break")){ xdebug_break(); } ?>'
        );
    }
}
