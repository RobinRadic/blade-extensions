<?php

use Mockery as m;
use Radic\BladeExtensions\BladeExtensionsServiceProvider;
use Radic\BladeExtensions\Testing\BladeViewTestingTrait;

class ForeachViewTest extends Orchestra\Testbench\TestCase
{
    use BladeViewTestingTrait;

    protected $data;

    public function setUp()
    {
        parent::setUp();

        $this->addTestAssertsBladeDirectives();

        $this->app->register(new BladeExtensionsServiceProvider($this->app));
        //$this->app->register(new IdeHelperServiceProvider($this->app));
        //$this->app->artisan->call('ide-helper:generate');
        $this->data = json_decode(File::get(__DIR__ . '/data.json'), true);
        View::addLocation(__DIR__ . '/views');
    }


    public function testForeachSetCount()
    {
        $html = View::make('foreach', ['value' => $this->data, 'array' => $this->data[0], 'getArray' => function () {
            return $this->data;
        }])->render();
        $this->assertTrue(true);

    }


}