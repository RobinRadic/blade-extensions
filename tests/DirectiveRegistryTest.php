<?php
/**
 * Copyright (c) 2016. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2016 (c) Robin Radic
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
        return new DirectiveRegistry($this->container = Mockery::mock('Illuminate\Contracts\Container\Container'));
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
    }
}