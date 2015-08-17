<?php namespace Radic\Tests\BladeExtensions;

use Caffeinated\Dev\Testing\AbstractTestCase;
use Caffeinated\Dev\Testing\Traits\BladeViewTester;
use Collective\Html\HtmlServiceProvider;

/**
 * Class ViewTest
 *
 * @author     Robin Radic
 * @inheritDoc
 */
abstract class TestCase extends AbstractTestCase
{
    use BladeViewTester;

    /** @inheritDoc */
    public function setUp()
    {
        parent::setUp();
    }

    /** @var array */
    public static $data;

    /**
     * @return DataGenerator
     */
    public static function getData()
    {
        if (!isset(static::$data)) {
            static::$data = new DataGenerator();
        }
        return static::$data;
    }

    /**
     * @return \Illuminate\Contracts\View\Factory
     */
    public function view()
    {
        return $this->app[ 'view' ];
    }

    protected function getEnvironmentSetUp($app)
    {

        $config = $app->make('config');
        $config->set('app.key', 'sG7qHHCc0jAseXbQx5BEv8DiZn4x7p4C');
        parent::getEnvironmentSetUp($app);
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
        #$instance = new $class($this->app);
        $this->app->register($class);
    }

    protected function registerBladeMarkdown()
    {
        $this->app->register('Radic\BladeExtensions\Providers\MarkdownServiceProvider'); //new MarkdownServiceProvider($this->app));
    }
}
