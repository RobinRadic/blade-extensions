<?php namespace Radic\BladeExtensions\Traits;

use Radic\BladeExtensions\BladeExtensionsServiceProvider;

/**
 * Adds functionality to test blade views in PHPUnit Tests
 *
 * @package        Radic\BladeExtensions
 * @subpackage     Traits
 * @version        1.3.0
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2014, Robin Radic - Radic Technologies
 * @link           http://robin.radic.nl/blade-extensions
 *
 */
trait BladeViewTestingTrait
{

    /**
     * The Laravel View Factory instance
     *
     * @var \Illuminate\View\Factory views
     */
    protected $view;

    /**
     * The View factory's blade compiler
     *
     * @var \Illuminate\View\Compilers\BladeCompiler
     */
    protected $blade;

    /**
     * Adds all class methods prefixed with assert* as blade view directives
     * and assigns the $view and $blade class properties
     *
     * @param string $viewDirectoryPath The path to the directory containing test views
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

    /**
     * Registers the service provider with the app
     */
    public function registerBladeProvider()
    {
        $this->app->register(new BladeExtensionsServiceProvider($this->app));
    }
}
