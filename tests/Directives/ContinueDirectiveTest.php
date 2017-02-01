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
        $this->assertEquals(
            $this->getDirective()->setName('continue')->handle('@continue'),
            '<?php app("blade-extensions.helpers")->get("loop")->looped(); continue; ?>'
        );
    }
}
