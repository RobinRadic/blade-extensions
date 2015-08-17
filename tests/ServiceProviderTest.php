<?php namespace Radic\Tests\BladeExtensions;

use Mockery as m;
use Caffeinated\Dev\Testing\Traits\ServiceProviderTester;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 * @group blade-extensions
 */
class ServiceProviderTest extends TestCase
{
    use ServiceProviderTester;

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
