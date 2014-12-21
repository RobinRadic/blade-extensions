<?php
require(__DIR__ . '/../psysh.phar');
use Radic\BladeExtensions\BladeExtensionsServiceProvider;
use Radic\BladeExtensions\Testing\BladeViewTestingTrait;
use Illuminate\Foundation\Testing\TestCase;


class TestBase extends TestCase
{
    protected $data;

    public function __construct(){
        //$psy = Phar::loadPhar('psysh.phar', 'Psy');
    }

    public function setUp()
    {

        parent::setUp();

        require_once('data/TestData.php');
        $this->data = new TestData();
        //Phar::mount()

        $this->app['view']->addLocation(__DIR__ . '/views');
    }



    public function createApplication()
    {

        $app = new Illuminate\Foundation\Application(
            realpath(__DIR__.'/../')
        );


        $app->singleton(
            'Illuminate\Contracts\Http\Kernel',
            'App\Http\Kernel'
        );

        $app->singleton(
            'Illuminate\Contracts\Console\Kernel',
            'App\Console\Kernel'
        );

        $app->singleton(
            'Illuminate\Contracts\Debug\ExceptionHandler',
            'App\Exceptions\Handler'
        );

        $app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

        return $app;
    }
}
