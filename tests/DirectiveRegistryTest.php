<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2017 (c) Robin Radic
 * @license https://radic.mit-license.org The MIT License
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

    public function test_set_accepts_array()
    {
        $dir = $this->createInstance();
        $dir->register('set', function(){
            $args = func_get_args();
        });
        $dir->register('unset', function(){
            $args = func_get_args();
        });

        $dir->register([
            'set' => function(){
                $args = func_get_args();

                return $args;
            }
        ]);

        $dir->call('unset', [ 'sdf' ]);
    }

    public function test_handles_closures()
    {
        $output = $this->createInstance()->register('test', function ($value) {
            return $value . $value;
        })->call('test', [ 'foo' ]);
        $this->assertEquals('foofoo', $output);
    }
}