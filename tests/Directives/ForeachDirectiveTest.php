<?php
namespace Radic\Tests\BladeExtensions\Directives;

use Radic\Tests\BladeExtensions\DataGenerator;
use Radic\Tests\BladeExtensions\DirectivesTestCase;

class ForeachDirectiveTest extends DirectivesTestCase
{
    protected function getDirectiveClass()
    {
        return 'Radic\BladeExtensions\Directives\ForeachDirective';
    }

    public function testView()
    {
        $this->render('directives.foreach',[
            'dataClass' => static::getData(),
            'array'     => static::getData()->getRecords(),
            'getArray'  => function () {
                return static::getData()->getValues()[ 'names' ];
            }
        ]);
    }
}
