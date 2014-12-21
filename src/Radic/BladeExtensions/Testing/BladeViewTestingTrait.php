<?php namespace Radic\BladeExtensions\Testing;

/**
 * Part of Radic - Blade Extensions.
 *
 * @package    Blade Extensions
 * @version    1.2.0
 * @author     Robin Radic
 * @license    MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2014, Robin Radic - Radic Technologies
 * @link       http://radic.nl
 *
 */
trait BladeViewTestingTrait
{
    public function addTestAssertsBladeDirectives()
    {
        $view = $this->app['view'];

        // Add instance of current test class, this enable to call assert functions in views
        $view->share('testClassInstance', $this);

        // Lets make those assertions callable by fancy blade directives, nom nom nom
        $blade = $view->getEngineResolver()->resolve('blade')->getCompiler();

        $blade->extend(function ($value) {


            return preg_replace('/@assert(\w*)\((.*)\)/', "<?php \$testClassInstance->assert$1($2); ?>", $value);
        });
    }
}
