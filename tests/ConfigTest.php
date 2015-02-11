<?php namespace Radic\BladeExtensionsTests;

use Mockery as m;
use Radic\BladeExtensions\BladeExtensionsServiceProvider;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 *
 */
class ConfigTest extends TestCase
{


    public function setUp()
    {
        parent::setUp();
    }

    public function getConfig()
    {
        return $this->app['config']->get('blade-extensions'); // . (isset($key) ? '.' . $key : ''));
    }

    public function testConfigSettings()
    {
        //$this->generateIdeHelper();
        //$this->getKernel()->call('vendor:publish');
        $config = $this->getConfig();
        //$this->assertArrayNotHasKey('doMacro', $config);

    }
}
