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

/**
 * Class ViewTest.
 *
 * @author     Robin Radic
 * @group      blade-extensions
 */
class UnsetDirectiveTest extends DirectiveTestCase
{
    /**
     * getDirectiveClass method.
     * @return string
     */
    protected function getDirectiveClass()
    {
        return 'Radic\BladeExtensions\Directives\UnsetDirective';
    }

    /**
     * Test the set directive.
     */
    public function testView()
    {
        $this->render('directives.unset', [
            'dataString'        => 'hello',
            'dataArray'         => static::getData()->getValues()[ 'names' ],
            'dataClassInstance' => static::getData(),
            'dataClassName'     => 'DataGenerator',
        ]);
    }
}
