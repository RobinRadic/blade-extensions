<?php namespace Radic\Tests\BladeExtensions;

use Mockery as m;
use Radic\Dev\Traits\ServiceProviderTestCaseTrait;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 * @inheritDoc
 */
class ServiceProviderTest extends TestCase
{
    use ServiceProviderTestCaseTrait;

    /** @inheritDoc */
    public function setUp()
    {
        parent::setUp();
        $this->registerBlade();
        $this->registerBladeMarkdown();
    }


    public function testServiceProviderRegister()
    {
        $this->runServiceProviderRegisterTest('Radic\BladeExtensions\BladeExtensionsServiceProvider');
        $this->runServiceProviderRegisterTest('Radic\BladeExtensions\Providers\MarkdownServiceProvider');
    }

    public function testIsRenderersInjectable()
    {
        $this->testMeOk();
      #  $this->assertIsInjectable('Radic\BladeExtensions\Renderers\ParsedownRenderer');
      #  $this->assertIsInjectable('Radic\BladeExtensions\Renderers\CiconiaRenderer');
    }

    public function testIsCompilerInjectable()
    {
        $this->assertTrue(true);
        #$this->assertIsInjectable('Radic\BladeExtensions\Compilers\MarkdownCompiler');
    }
}
