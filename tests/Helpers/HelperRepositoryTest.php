<?php

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

        foreach ($this->helperClasses as $name => $class) {
            $this->helperMocks[ $name ] = m::mock($class);
            $this->container
                ->shouldReceive('make')
                ->once()->with(m::anyOf($class))
                ->andReturn($this->helperMocks[ $name ]);
        }

        return new HelperRepository($this->container);
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
