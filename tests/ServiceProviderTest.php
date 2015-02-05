<?php

use Mockery as m;
use Radic\BladeExtensions\Traits\BladeViewTestingTrait;


class ServiceProviderTest extends Orchestra\Testbench\TestCase
{
    use BladeViewTestingTrait;

    public function setUp()
    {
        parent::setUp();
        $this->addBladeViewTesting(__DIR__ . '/views');
    }

    public function testServiceProvider()
    {
        $this->registerBladeProvider();
        $loadedProviders = $this->app->getLoadedProviders();
        $this->assertArrayHasKey('Radic\BladeExtensions\BladeExtensionsServiceProvider', $loadedProviders);
        $this->assertTrue($loadedProviders['Radic\BladeExtensions\BladeExtensionsServiceProvider']);
    }
}
