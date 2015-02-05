<?php namespace Radic\BladeExtensions\Traits;

use Radic\BladeExtensions\BladeExtensionsServiceProvider;

/**
 * Part of Radic - Blade Extensions.
 *
 * @package        Blade Extensions
 * @version        1.2.0
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2014, Robin Radic - Radic Technologies
 * @link           http://radic.nl
 *
 */
trait BladeViewTestingTrait
{

    /**
     * @var \Illuminate\View\Factory views
     */
    protected $view;

    /**
     * @var \Illuminate\View\Compilers\BladeCompiler
     */
    protected $blade;

    /**
     * Adds all class methods prefixed with assert* as blade view directives
     * and assigns the $view and $blade class properties
     *
     * @param string [$viewDirectoryPath] - The path to the directory containing test views
     */
    public function addBladeViewTesting($viewDirectoryPath = null)
    {

        $this->view = $this->app['view'];

        // Add instance of current test class, this enable to call assert functions in views
        $this->view->share('testClassInstance', $this);

        // Lets make those assertions callable by fancy blade directives, nom nom nom
        $this->blade = $this->view->getEngineResolver()->resolve('blade')->getCompiler();

        $this->blade->extend(
            function ($value) {
                return preg_replace('/@assert(\w*)\((.*)\)/', "<?php \$testClassInstance->assert$1($2); ?>", $value);
            }
        );

        if ($viewDirectoryPath !== null) {
            $this->view->addLocation($viewDirectoryPath);
        }
    }

    public function registerBladeProvider()
    {
        $this->app->register(new BladeExtensionsServiceProvider($this->app));
    }



    public function doDirectiveTest($directiveClass)
    {

        $methods = get_class_methods($directiveClass);
        //echo var_dump($methods);

        foreach ($methods as $method) {
            $this->assertTrue(method_exists($directiveClass, $method));
        }

        $app = $this->app;
        $blade = $this->blade;

        foreach ($methods as $method) {
            $this->blade->extend(function ($value) use ($app, $directiveClass, $blade, $method) {

                echo $method;
                $str = $directiveClass->$method($value, $app, $blade);
                $this->assertStringStartsWith('<?php', $str);

                return $str;
            });
        }
    }

}
