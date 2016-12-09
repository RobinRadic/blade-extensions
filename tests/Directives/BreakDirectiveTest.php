<?php
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
