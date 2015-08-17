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
        $this->registerBlade();
    }

    public function getConfig()
    {
        return $this->app[ 'config' ]->get('blade_extensions'); // . (isset($key) ? '.' . $key : ''));
    }

    public function testConfigSettings()
    {
        $config = $this->getConfig();

        $this->assertTrue(is_array($config), 'Config should be an array');

        $this->assertTrue(is_array($config[ 'blacklist' ]), 'config.blacklist should be an array');
        $this->assertTrue(count($config[ 'blacklist' ]) === 0, 'config.blacklist should be empty');
        $this->app[ 'config' ]->set('blade_extensions.blacklist', array( 'debug', 'unset', 'set' ));
        $config = $this->getConfig();
        $this->assertTrue(count($config[ 'blacklist' ]) === 3, 'config.blacklist should have 3 items');
    }

    public function testConfigReset()
    {
        #File::delete(File::glob(app_path('config/blade_') . '*'));
        #$this->command('vendor:publish');
        #$this->assertTrue(true);
    }
}
