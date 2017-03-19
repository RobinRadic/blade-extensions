<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright 2017 Robin Radic
 * @license https://radic.mit-license.org MIT License
 * @version 7.0.0 Radic\BladeExtensions
 */

namespace Radic\Tests\BladeExtensions;

use Laradic\Testing\Laravel\Traits\ViewTester;

/**
 * {@inheritdoc}
 */
abstract class DirectiveTestCase extends TestCase
{
    use ViewTester;

    public function setUp()
    {
        parent::setUp();

        $this->registerServiceProvider();
        $this->addViewTesting(true, __DIR__.'/views');
        $this->cleanViews();
    }

    public function render($view, $data = [])
    {
        return $this->app[ 'view' ]->make($view, $data)->render();
    }

    /**
     * getDirectiveClass method.
     *
     * @return string
     */
    abstract protected function getDirectiveClass();

    /**
     * getDirective method.
     *
     * @return \Radic\BladeExtensions\Directives\DirectiveInterface|mixed
     */
    public function getDirective()
    {
        return $this->app->make($this->getDirectiveClass());
    }

    public function testPatternIsValidRegex()
    {
        $class = $this->getDirective();
        $this->assertValidRegularExpression($class->getPattern());
    }

    protected $testSetPattern = '/a/';

    public function testSettersAndGetters()
    {
        $class = $this->getDirective();

        $class->setPattern($this->testSetPattern);
        $this->assertEquals($class->getPattern(), $this->testSetPattern);

        $class->setName('a');
        $this->assertEquals($class->getName(), 'a');

        $class->setReplace('a');
        $this->assertEquals($class->getReplace(), 'a');
    }

    public function testCompatibility()
    {
        /* @var \Radic\BladeExtensions\Directives\DirectiveInterface $class */
//        $class = $this->getDirectiveClass();
        // @todo
        $this->assertFalse(false);
        //$class::isCompatibleWithVersion('4.0'));
    }
}
