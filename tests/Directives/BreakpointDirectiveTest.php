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
        $this->assertEquals($this->view()->make('directives.breakpoint')->render(), '');
    }

    public function testReplace()
    {
        $class = $this->getDirective();
        $class->setName('breakpoint');
        $this->assertEquals($class->handle('@breakpoint'), $class->getReplace());
    }
}
