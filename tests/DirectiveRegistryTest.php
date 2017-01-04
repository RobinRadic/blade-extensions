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

use Radic\BladeExtensions\DirectiveRegistry;

class DirectiveRegistryTest extends TestCase
{
    protected $app;

    protected function createInstance()
    {
        $this->app = \Mockery::mock('Illuminate\Foundation\Application');
        return new DirectiveRegistry($this->app);
    }

    public function test_set_accepts_array()
    {
        $dir = $this->createInstance();
        $dir->set('set', function(){
            $args = func_get_args();
        });
        $dir->set('unset', function(){
            $args = func_get_args();
        });

        $dir->set([
            'set' => function(){
                $args = func_get_args();

                return $args;
            }
        ]);
    }
}