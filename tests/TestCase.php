<?php namespace Radic\Tests\BladeExtensions;

use Laradic\Testing\Laravel\Traits\ViewTester;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 * @inheritDoc
 */
abstract class TestCase extends \Laradic\Testing\Laravel\AbstractTestCase
{
    use ViewTester;

    /** @inheritDoc */
    public function setUp()
    {
        parent::setUp();
    }

    /** @var array */
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
        return realpath(__DIR__ . '/..');
    }

}
