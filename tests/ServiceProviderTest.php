<?php namespace Radic\Tests\BladeExtensions;

use Mockery as m;
use Laradic\Dev\Traits\ServiceProviderTestCaseTrait;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 * @group blade-extensions
 */
class ServiceProviderTest extends TestCase
{
    use ServiceProviderTestCaseTrait;

    /** @inheritDoc */
    public function setUp()
    {
        parent::setUp();
    }


    public function testServiceProviderRegister()
    {
        $this->registerBlade();
        $this->registerBladeMarkdown();
        $this->runServiceProviderRegisterTest('Radic\BladeExtensions\BladeExtensionsServiceProvider');
        $this->runServiceProviderRegisterTest('Radic\BladeExtensions\Providers\MarkdownServiceProvider');
    }

}
