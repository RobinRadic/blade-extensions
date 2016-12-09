<?php
namespace Radic\Tests\BladeExtensions\Directives;

use Radic\Tests\BladeExtensions\DirectivesTestCase;

class BreakpointDirectiveTest extends DirectivesTestCase
{
    /**
     * getDirectiveClass method
     * @return string
     */
    protected function getDirectiveClass()
    {
        return 'Radic\BladeExtensions\Directives\BreakpointDirective';
    }

    /**
     * Test the set directive
     */
    public function testView()
    {
        $this->assertEquals($this->render('directives.breakpoint'), '');
    }

    public function testReplace()
    {
        $this->assertEquals($this->getDirective()->setName('breakpoint')->handle('@breakpoint'), '<?php if(function_exists("xdebug_break")){ xdebug_break(); } ?>');
    }
}
