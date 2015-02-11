<?php namespace Radic\BladeExtensionsTests;

use Mockery as m;
use Radic\BladeExtensions\BladeExtensionsServiceProvider;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 *
 */
class ServiceProviderTest extends TestCase
{


    public function setUp()
    {
        parent::setUp();
    }


    public function testServiceProvider()
    {
        $this->app->register(new BladeExtensionsServiceProvider($this->app));
        $providers = $this->app->getLoadedProviders();
        $this->assertArrayHasKey('Radic\BladeExtensions\BladeExtensionsServiceProvider', $providers);
        $this->assertTrue($providers['Radic\BladeExtensions\BladeExtensionsServiceProvider']);
    }

}
