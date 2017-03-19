<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright 2017 Robin Radic
 * @license https://radic.mit-license.org MIT License
 * @version 7.0.0 Radic\BladeExtensions
 */
namespace Radic\Tests\BladeExtensions\Directives;

use Radic\BladeExtensions\Helpers\BladeMatchers;
use Radic\Tests\BladeExtensions\DirectiveTestCase;

class IfSectionDirectiveTest extends DirectiveTestCase
{
    public function testSettersAndGetters()
    {
        $this->testSetPattern = BladeMatchers::$createMatcher;
        parent::testSettersAndGetters();
    }


    /**
     * getDirectiveClass method.
     *
     * @return string
     */
    protected function getDirectiveClass()
    {
        return 'Radic\BladeExtensions\Directives\IfSectionDirective';
    }

    public function testView()
    {
        $rendered = $this->render('directives.if-section.if-section', []);

        $this->assertTrue(true);
    }
}
