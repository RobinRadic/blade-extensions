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
use PHPUnit\Framework\Assert;

/**
 * Class ViewTest.
 *
 * @author     Robin Radic
 * {@inheritdoc}
 */
abstract class TestCase extends \Laradic\Testing\Laravel\AbstractTestCase
{
    use ViewTester;

    /** {@inheritdoc} */
    public function setUp()
    {
        parent::setUp();
    }

    /** @var DataGenerator */
    public static $data;

    /**
     * @return DataGenerator
     */
    public static function getData()
    {
        if (! isset(static::$data)) {
            static::$data = new DataGenerator();
        }

        return static::$data;
    }

    /**
     * Get the service provider class.
     *
     * @return string
     */
    protected function getServiceProviderClass()
    {
        return 'Radic\BladeExtensions\BladeExtensionsServiceProvider';
    }

    protected function getPackageRootPath()
    {
        return realpath(__DIR__.'/..');
    }

    public function testTest()
    {
        $this->assertTrue(true);
    }

    /**
     * assertValidRegularExpression method.
     *
     * @param mixed  $value
     * @param string $message
     *
     * @return void
     */
    public function assertValidRegularExpression($value, $message = '')
    {
        // http://stackoverflow.com/questions/4440626/how-can-i-validate-regex
        Assert::assertThat(@preg_match($value, null), Assert::logicalNot(Assert::isFalse()), $message);
    }
}
