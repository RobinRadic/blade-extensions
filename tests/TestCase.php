<?php namespace Radic\Tests\BladeExtensions;

use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Html\HtmlServiceProvider;
use Radic\BladeExtensions\BladeExtensionsServiceProvider;

use Radic\BladeExtensions\Providers\MarkdownServiceProvider;
use Radic\Testing\AbstractTestCase;
use Radic\Testing\Traits\BladeViewTestingTrait;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 * @inheritDoc
 */
class TestCase extends AbstractTestCase
{
    use BladeViewTestingTrait;

    /**
     * @var TestData
     */
    protected $data;

    /** @inheritDoc */
    public function setUp()
    {
        parent::setUp();
        $this->data = new TestData();
    }

    public function getData()
    {
        return $this->data;
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
        \File::delete(\File::glob(base_path('storage/framework/views') . '/*'));
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
        $this->app->register(new BladeExtensionsServiceProvider($this->app));
    }

    protected function registerBladeMarkdown()
    {
        $this->app->register(new MarkdownServiceProvider($this->app));
    }

}
