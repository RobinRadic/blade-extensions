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

use Laradic\Testing\Native\AbstractTestCase;
use Radic\BladeExtensions\HelperRepository;
use Radic\BladeExtensions\Helpers\Embed\EmbedHelper;
use Radic\BladeExtensions\Helpers\Loop\LoopHelper;
use Radic\BladeExtensions\Helpers\Markdown\MarkdownHelper;
use Radic\BladeExtensions\Helpers\Minifier\MinifierHelper;

class HelperRepositoryTest extends AbstractTestCase
{
    public function test_can_create_instance()
    {
        $this->assertInstanceOf(HelperRepository::class, new HelperRepository());
    }


    /**
     * @var \Mockery\MockInterface
     */
    protected $container;

    /**
     * @var
     */
    protected $helperMocks;

    protected $helperClasses;

    protected function setUp()
    {
        parent::setUp();

        $this->container   = \Mockery::mock('Illuminate\Contracts\Container\Container');
        $this->helperMocks = [ ];

        $this->helperClasses = [
            'loop'     => LoopHelper::class,
            'embed'    => EmbedHelper::class,
            'markdown' => MarkdownHelper::class,
            'minifier' => MinifierHelper::class
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
            $this->helperMocks[ $name ] = \Mockery::mock($class);
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