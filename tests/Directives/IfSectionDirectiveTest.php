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

use Radic\BladeExtensions\Directives\AbstractDirective;
use Radic\Tests\BladeExtensions\DirectiveTestCase;

class IfSectionDirectiveTest extends DirectiveTestCase
{
    protected $testSetPattern = AbstractDirective::OPEN_MATCHER;

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
        $this->assertIfSection('title', [ 'title:title' ]);
        $this->assertIfSection('title-content', [ 'title:title', 'content:content' ]);
        $this->assertIfSection('title-sidebar-content', [ 'title:title', 'sidebar:sidebar', 'content:content' ]);
    }

    protected function assertIfSection($view, array $arr)
    {
        $out = explode(';', preg_replace("/\n/", "", $this->render('directives.if-section.' . $view)));
        array_pop($out);
        $this->assertEquals($arr, $out);
    }
}
