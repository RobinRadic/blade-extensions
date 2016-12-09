<?php
namespace Radic\Tests\BladeExtensions;

use Laradic\Testing\Laravel\Traits\ViewTester;

abstract class DirectivesTestCase extends TestCase
{
    use ViewTester;

    public function setUp()
    {
        parent::setUp();

        $this->registerServiceProvider();
        $this->addViewTesting(true, __DIR__ . '/views');
        $this->cleanViews();
    }

    public function render($view, $data = [])
    {
        return $this->app[ 'view' ]->make($view, $data)->render();
    }


    /**
     * getDirectiveClass method
     * @return string
     */
    abstract protected function getDirectiveClass();


    /**
     * getDirective method
     * @return \Radic\BladeExtensions\Directives\Directive|mixed
     */
    public function getDirective()
    {
        return $this->app->make($this->getDirectiveClass());
    }


    public function testPatternIsValidRegex()
    {
        $class = $this->getDirective();
        $this->matchesRegularExpression($class->getPattern());
    }

    public function testSettersAndGetters()
    {
        $class = $this->getDirective();

        $class->setPattern('/a/');
        $this->assertEquals($class->getPattern(), '/a/');

        $class->setName('a');
        $this->assertEquals($class->getName(), 'a');

        $class->setReplace('a');
        $this->assertEquals($class->getReplace(), 'a');
    }



}
