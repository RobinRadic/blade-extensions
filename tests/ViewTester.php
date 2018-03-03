<?php
/**
 * Copyright (c) 2018. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright 2018 Robin Radic
 * @license https://radic.mit-license.org MIT License
 * @version 7.0.0 Radic\BladeExtensions
 */

namespace Radic\Tests\BladeExtensions;

/**
 * This is the ViewTester.
 *
 * @package        Laradic\Testbench
 * @author         Laradic Dev Team
 * @copyright      Copyright (c) 2015, Laradic
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
trait ViewTester
{

    /**
     * Adds all class methods prefixed with assert* as blade view directives
     * and assigns the $view and $blade class properties
     *
     * @param bool   $addBlade
     * @param string $viewDirectoryPath The path to the directory containing test views
     */
    public function addViewTesting($addBlade = true, $viewDirectoryPath = null)
    {
        $view = $this->getView();

        // Add instance of current test class, this enable to call assert functions in views
        $view->share('testClassInstance', $this);

        if ($viewDirectoryPath !== null) {
            $view->addLocation($viewDirectoryPath);
        }

        if ($addBlade) {
            $this->getBlade()->extend(
                function ($value) {

                    return preg_replace('/@assert(\w*)\((.*)\)/', "<?php \$testClassInstance->assert$1($2); ?>", $value);
                }
            );
        }
    }

    /**
     * Clean all cached/compiled views
     */
    protected function cleanViews()
    {
        $fs = $this->app->make('files');
        $fs->delete($fs->glob(base_path('storage/framework/views') . '/*'));
    }

    /**
     * Get the view Factory
     *
     * @return \Illuminate\View\Factory
     */
    protected function getView()
    {
        return $this->app->make('view');
    }

    /**
     * Get the BladeCompiler
     *
     * @return \Illuminate\View\Compilers\BladeCompiler
     */
    protected function getBlade()
    {
        return $this->getView()->getEngineResolver()->resolve('blade')->getCompiler();
    }
}
