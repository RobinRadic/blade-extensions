<?php namespace Radic\Tests\BladeExtensions;

use Mockery as m;
use Radic\BladeExtensions\BladeExtensionsServiceProvider;
use Radic\Testing\AbstractTestCase;
use Radic\Testing\Traits\ServiceProviderTestCaseTrait;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 * @inheritDoc
 */
class ServiceProviderTest extends AbstractTestCase
{
    use ServiceProviderTestCaseTrait;

    /** @inheritDoc */
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

    /**
     * Get the service provider class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return string
     */
    protected function getServiceProviderClass($app)
    {
        return 'Radic\BladeExtensions\BladeExtensionsServiceProvider';
    }
}
