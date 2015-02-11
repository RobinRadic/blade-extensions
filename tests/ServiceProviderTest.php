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

    public function testConfigSettings()
    {
        //$this->generateIdeHelper();
        $this->getKernel()->call('config:clear');
        //$this->getKernel()->call('vendor:publish');
        var_dump($this->app['config']->get('blade-extensions'));
    }
}
