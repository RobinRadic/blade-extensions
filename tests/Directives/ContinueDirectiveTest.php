<?php
namespace Radic\Tests\BladeExtensions\Directives;

use Radic\Tests\BladeExtensions\DirectivesTestCase;

class ContinueDirectiveTest extends DirectivesTestCase
{
    /**
     * getDirectiveClass method
     * @return string
     */
    protected function getDirectiveClass()
    {
        return 'Radic\BladeExtensions\Directives\ContinueDirective';
    }

    public function testReplace()
    {
        $this->assertEquals($this->getDirective()->setName('continue')->handle('@continue'), '<?php app("blade.helpers")->get("loop")->looped(); continue; ?>');

    }
}
