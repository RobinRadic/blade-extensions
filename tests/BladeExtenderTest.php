<?php

use Radic\BladeExtensions\BladeExtender;

class BladeExtenderTest extends TestBase
{
    public function setUp()
    {
        parent::setUp();
    }


    public function testExtendMethods()
    {

        $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();
        $app = $this->app;
        $bladeExtender = new BladeExtender();
        $methods = get_class_methods($bladeExtender);
        //echo var_dump($methods);

        foreach ($methods as $method) {
            $this->assertTrue(method_exists($bladeExtender, $method));
        }

        foreach ($methods as $method) {
            $blade->extend(function ($value) use ($app, $bladeExtender, $blade, $method) {

                echo $method;
                $str = $bladeExtender->$method($value, $app, $blade);
                $this->assertStringStartsWith('<?php', $str);
                return $str;
            });
        }


    }


}
