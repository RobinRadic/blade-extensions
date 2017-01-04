<?php
/**
 * Copyright (c) 2016. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2016 (c) Robin Radic
 * @license https://radic.mit-license.org The MIT License
 */
namespace Radic\Tests\BladeExtensions\Facades;

use Laradic\Testing\Laravel\Traits\FacadeTester;
use Radic\BladeExtensions\Facades\BladeString;
use Radic\Tests\BladeExtensions\TestCase;

/**
 * This is the BladeStringFacadeTest.
 *
 * @package        Radic\Tests
 * @author         Caffeinated Dev Team
 * @copyright      Copyright (c) 2015, Caffeinated
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class BladeStringFacadeTest extends TestCase
{
    use FacadeTester;

    /**
     * @inheritDoc
     */
    protected function start()
    {
        //$this->app->register()
        $this->registerServiceProvider();
    }


    /**
     * Get the facade accessor.
     *
     * @return string
     */
    protected function getFacadeAccessor()
    {
        return 'blade.string';
    }

    /**
     * Get the facade class.
     *
     * @return string
     */
    protected function getFacadeClass()
    {
        return BladeString::class;
    }

    /**
     * Get the facade route.
     *
     * @return string
     */
    protected function getFacadeRoot()
    {
        //return $this->app->make('blade.string');
        return \Radic\BladeExtensions\Renderers\BladeStringRenderer::class;
    }
}
