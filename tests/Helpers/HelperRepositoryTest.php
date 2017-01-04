<?php
/**
 * Copyright (c) 2016. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2016 (c) Robin Radic
 * @license https://radic.mit-license.org The MIT License
 */

namespace Radic\Tests\BladeExtensions\Helpers;

use Mockery as m;
use Radic\BladeExtensions\Helpers\EmbedStacker;
use Radic\BladeExtensions\Helpers\HelperRepository;
use Radic\BladeExtensions\Helpers\LoopFactory;
use Radic\BladeExtensions\Helpers\Markdown;
use Radic\BladeExtensions\Helpers\Minifier;
use Radic\Tests\BladeExtensions\TestCase;

class HelperRepositoryTest extends TestCase
{

    /**
     * @var \Mockery\MockInterface
     */
    protected $container;

    /**
     * @var
     */
    protected $helperMocks;

    protected $helperClasses;

    protected function start()
    {
        $this->container   = m::mock('Illuminate\Contracts\Container\Container');
        $this->helperMocks = [ ];

        $this->helperClasses = [
            'loop'     => LoopFactory::class,
            'embed'    => EmbedStacker::class,
            'markdown' => Markdown::class,
            'minifier' => Minifier::class
        ];
    }

    /**
     * _createHelperRepository
     *
     * @return \Radic\BladeExtensions\Helpers\HelperRepository
     */
    protected function _createHelperRepository()
    {
        $h = new HelperRepository($this->container);

        foreach ($this->helperClasses as $name => $class) {
            $this->helperMocks[ $name ] = m::mock($class);
            $h->put($name, $this->helperMocks[ $name ]);
        }

        return $h;
    }

    public function testGetHelperClassInstances()
    {

        $repository  = $this->_createHelperRepository();
        foreach ($this->helperMocks as $name => $m) {
            $helper = $repository->get($name, false);
            $this->assertNotFalse($helper);
            $this->assertInstanceOf($this->helperClasses[$name], $helper);
            $this->assertTrue($repository->has($name));
        }
        $repository->put('test', 'testClass');
        $this->assertEquals('testClass', $repository->get('test'));
    }
}
