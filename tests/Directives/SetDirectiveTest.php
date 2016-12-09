<?php namespace Radic\Tests\BladeExtensions\Directives;

use Mockery as m;
use Radic\Tests\BladeExtensions\DirectivesTestCase;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 * @group      blade-extensions
 */
class SetDirectiveTest extends DirectivesTestCase
{
    /**
     * getDirectiveClass method
     * @return string
     */
    protected function getDirectiveClass()
    {
        return 'Radic\BladeExtensions\Directives\SetDirective';
    }

    /**
     * Test the set directive
     */
    public function testView()
    {
        $this->render('directives.set', [
            'dataString'        => 'hello',
            'dataArray'         => static::getData()->getValues()[ 'names' ],
            'dataClassInstance' => static::getData(),
            'dataClassName'     => 'DataGenerator'
        ]);
    }
}
