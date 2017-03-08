<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright 2017 Robin Radic
 * @license https://radic.mit-license.org MIT License
 * @version 7.0.0
 */

namespace Radic\Tests\BladeExtensions;

use Laradic\Testing\Laravel\Traits\ServiceProviderTester;

/**
 * Class ViewTest.
 *
 * @author     Robin Radic
 * @group blade-extensions
 */
class BladeExtensionsServiceProviderTest extends TestCase
{
    use ServiceProviderTester;

    /**
     * {@inheritdoc}
     */
    protected function start()
    {
        $this->registerServiceProvider();
    }

    public function testServiceProviderRegister()
    {
        $this->runServiceProviderRegisterTest('Radic\BladeExtensions\BladeExtensionsServiceProvider');
    }

    protected function getPackageRootPath()
    {
        return __DIR__.DIRECTORY_SEPARATOR.'..';
    }
}
