<?php namespace Radic\Tests\BladeExtensions;

use Mockery as m;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 * @group      blade-extensions
 *
 */
class ConfigTest extends TestCase
{


    public function setUp()
    {
        parent::setUp();
        $this->registerServiceProvider();
    }

    public function getConfig()
    {
        return $this->app[ 'config' ]->get('blade-extensions'); // . (isset($key) ? '.' . $key : ''));
    }

    public function testConfigSettings()
    {
        $config = $this->getConfig();

        $this->assertTrue(is_array($config), 'Config should be an array');
    }
}
