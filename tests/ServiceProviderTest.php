<?php namespace Radic\Tests\BladeExtensions;

use Mockery as m;
use Laradic\Testing\Laravel\Traits\ServiceProviderTester;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 * @group blade-extensions
 */
class ServiceProviderTest extends TestCase
{
    use ServiceProviderTester;

    /**
     * @inheritDoc
     */
    protected function start()
    {
        $this->loadViewTesting();
        $this->registerServiceProvider();
    }


    public function testServiceProviderRegister()
    {
        $this->runServiceProviderRegisterTest('Radic\BladeExtensions\BladeExtensionsServiceProvider');
    }

}
