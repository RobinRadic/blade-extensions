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

    /**
     * @expectedException \Exception
     */
    public function testNonexistentRenderer()
    {
        $this->app->config->set('blade_extensions.markdown.renderer', 'Class\\Does\\Not\\Exist');
        $this->registerBlade();
        $this->registerBladeMarkdown();

    }
}
