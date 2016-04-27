<?php
/**
 * Part of the Caffeinated PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Radic\Tests\BladeExtensions\Facades;

use Sebwite\Testing\Laravel\Traits\FacadeTester;
use Radic\BladeExtensions\Facades\Markdown;
use Radic\Tests\BladeExtensions\TestCase;

/**
 * This is the BladeStringFacadeTest.
 *
 * @package        Radic\Tests
 * @author         Caffeinated Dev Team
 * @copyright      Copyright (c) 2015, Caffeinated
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class MarkdownFacadeTest extends TestCase
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
        return 'markdown';
    }

    /**
     * Get the facade class.
     *
     * @return string
     */
    protected function getFacadeClass()
    {
        return Markdown::class;
    }

    /**
     * Get the facade route.
     *
     * @return string
     */
    protected function getFacadeRoot()
    {
        //return $this->app->make('blade.string');
        return \Radic\BladeExtensions\Renderers\ParsedownRenderer::class;
    }
}
