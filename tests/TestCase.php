<?php namespace Radic\Tests\BladeExtensions;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Html\HtmlServiceProvider;
use Radic\BladeExtensions\Providers\MarkdownServiceProvider;
use Laradic\Dev\AbstractTestCase;
use Laradic\Dev\Traits\BladeViewTestingTrait;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 * @inheritDoc
 */
abstract class TestCase extends AbstractTestCase
{
    use BladeViewTestingTrait;

    /** @inheritDoc */
    public function setUp()
    {
        parent::setUp();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory
     */
    public function view()
    {
        return $this->app['view'];
    }

    /**
     * Get the service provider class.
     *
     * @param \Illuminate\Contracts\Foundation\Application $app
     *
     * @return string
     */
    protected function getServiceProviderClass($app)
    {
        return 'Radic\BladeExtensions\BladeExtensionsServiceProvider';
    }

    /**
     * Adds assertion directives to blade and removes cached views
     */
    protected function loadViewTesting()
    {
        $this->addBladeViewTesting(__DIR__ . '/views');
        $this->cleanViews();
    }

    /**
     * Registers the HtmlServiceProvider required for the macro directives
     */
    protected function registerHtml()
    {
        $this->app->register(new HtmlServiceProvider($this->app));
    }

    /**
     * Registers the BladeExtensionsServiceProvider
     */
    protected function registerBlade()
    {
        $class = $this->getServiceProviderClass($this->app);
        $instance = new $class($this->app);
        $this->app->register($instance);
    }

    protected function registerBladeMarkdown()
    {
        $this->app->register(new MarkdownServiceProvider($this->app));
    }
}
