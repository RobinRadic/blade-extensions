<?php namespace Radic\BladeExtensions\Testing;

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
            preg_replace('/@assert(\w*)\((.*)\)$/', "<?php \$testClassInstance->assert$1($2) ?>", $value);
        });
    }
}