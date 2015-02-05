<?php


use Mockery as m;
use Radic\BladeExtensions\BladeExtensionsServiceProvider;
use Radic\BladeExtensions\Directives\ForeachDirective;
use Radic\BladeExtensions\Directives\MacroDirective;
use Radic\BladeExtensions\Directives\PartialDirective;
use Radic\BladeExtensions\Directives\VariablesDirective;
use Radic\BladeExtensions\Traits\BladeViewTestingTrait;

class DirectivesTest extends Orchestra\Testbench\TestCase
{

    /**
     * @var TestData
     */
    protected $data;


    public function setUp()
    {
        parent::setUp();

        require_once(__DIR__ . '/data/TestData.php');
        $this->data = new TestData();

        // Add instance of current test class, this enable to call assert functions in views
        $this->app['view']->share('testClassInstance', $this);

        // Lets make those assertions callable by fancy blade directives, nom nom nom
        $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();

        $blade->extend(
            function ($value) {
                return preg_replace('/@assert(\w*)\((.*)\)/', "<?php \$testClassInstance->assert$1($2); ?>", $value);
            }
        );

        $this->app['view']->addLocation(__DIR__ . '/views');

        //$this->app->register(new IdeHelperServiceProvider($this->app));
        //$this->app->artisan->call('ide-helper:generate');
        //$this->app->artisan->call('cache:clear');
    }

    public function attach($classPath)
    {
        $class = new $classPath;
        $blade = $this->app['view']->getEngineResolver()->resolve('blade')->getCompiler();
        $app = $this->app;
        foreach (get_class_methods($class) as $method) {
            if ($method == 'attach') {
                continue;
            }

            $blade->extend(
                function ($value) use ($app, $class, $blade, $method) {
                    $str = $class->$method($value, $app, $blade);
                    $this->assertTrue(is_string($str));
                    return $str;
                }
            );
        }
    }

    public function testSet()
    {
        $this->attach('Radic\BladeExtensions\Directives\VariablesDirective');

        //VariablesDirective::attach($this->app);
        //$this->doDirectiveTest(new VariablesDirective($this->app));
        $this->app['view']->make(
            'set',
            [
                'dataString'        => 'hello',
                'dataArray'         => $this->data->array,
                'dataClassInstance' => $this->data,
                'dataClassName'     => 'TestData'
            ]
        )->render();
    }

    public function AtestForeach()
    {
        //$this->doDirectiveTest(new ForeachDirective($this->app));
        $this->view->make(
            'foreach',
            [
                'dataClass' => $this->data,
                'array'     => $this->data->array,
                'getArray'  => $this->data->getArrayGetterFn()
            ]
        )->render();
    }


    public function AtestMacros()
    {

        //$this->doDirectiveTest(new MacroDirective($this->app));
        $this->assertEquals('my age is3', $this->view->make('macro')->render());
        $this->assertEquals('my age is 6', $this->view->make('macro2')->render());
        $this->assertEquals('patatmy age is3', $this->view->make('macro3')->render());
    }


    public function AtestPartials()
    {

        //$this->doDirectiveTest(new PartialDirective($this->app));
        $partials = $this->view->make('partials')->render();
        $this->assertEquals("okokok", str_replace("\n", '', $partials));
    }
}
