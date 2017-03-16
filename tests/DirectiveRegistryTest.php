<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright 2017 Robin Radic
 * @license   https://radic.mit-license.org MIT License
 * @version   7.0.0
 */

namespace Radic\Tests\BladeExtensions;

use Mockery;
use Radic\BladeExtensions\DirectiveRegistry;

class DirectiveRegistryTest extends TestCase
{
    protected $container;

    protected function createInstance()
    {
        return new DirectiveRegistry($this->container = Mockery::mock('Illuminate\Contracts\Foundation\Application'));
    }

    public function testRegisterAcceptsArray()
    {
        $dir = $this->createInstance();

        $dir->register([
            'set' => function () {
            },
        ]);

        $this->assertTrue($dir->has('set'));
    }

    public function testCallRegisteredClosure()
    {
        $output = $this->createInstance()->register('test', function ($value) {
            return $value.$value;
        })->call('test', ['foo']);
        $this->assertEquals('foofoo', $output);
    }
}
