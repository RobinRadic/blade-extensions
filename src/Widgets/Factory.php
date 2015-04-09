<?php
/**
 * Part of the Laradic packages.
 */
namespace Radic\BladeExtensions\Widgets;

use Illuminate\Contracts\View\Factory as ViewFactory;
use Radic\BladeExtensions\Helpers\Sections;

/**
 * Class Factory
 *
 * @package     Radic\BladeExtensions\Widgets
 * @author      Robin Radic
 * @license     MIT
 * @copyright   2011-2015, Robin Radic
 * @link        http://radic.mit-license.org
 */
class Factory
{

    protected $sections;

    /**
     * @var Widget[]
     */
    protected $widgets = [];

    /**
     * @var \Illuminate\View\Factory
     */
    protected $view;

    /**
     * @var string[]
     */
    protected $widgetClasses = [];

    protected $widgetStack = [];

    /**
     * Instantiates the class
     *
     * @param \Illuminate\Contracts\View\Factory $view
     * @internal param \Radic\BladeExtensions\Helpers\Sections $sections
     */
    public function __construct(ViewFactory $view)
    {
        $this->view = $view;

        $this->sections = new Sections($view);
    }

    public function register($name, $className)
    {
        $this->widgetClasses[$name] = $className;

        return $this;
    }

    public function create($name)
    {
        if ( $this->has($name) )
        {
            return $this->get($name);
        }

        if(!isset($this->widgetClasses[$name]))
        {
            throw new \InvalidArgumentException("Could not instantiate widget [$name]. Widget has not been registered");
        }

        return $this->widgets[$name] = new $this->widgetClasses[$name]($this, $name);
    }

    /**
     * get
     *
     * @param $name
     * @return null|Widget
     */
    public function get($name)
    {
        return $this->widgets[$name];
    }

    public function has($name)
    {
        return isset($this->widgets[$name]);
    }

    public function render($name)
    {
        $widget = $this->create($name);

        return $widget->render();
    }


    public function openWidget($name)
    {
        $this->widgetStack[] = $name;
        $widget = $this->create($name);
        $widget->startContent();
    }

    public function getCurrentWidgetName()
    {
        return end($this->widgetStack);
    }
    public function getCurrentWidget()
    {
        return $this->create($this->getCurrentWidgetName());
    }

    public function closeWidget()
    {
        $lastWidgetName = array_pop($this->widgetStack);
        $widget = $this->create($lastWidgetName);
        $view = $widget->getView();
        echo $view->render();
        $widget->stopContent();
        var_dump($view);
    }

    /**
     * getBladeCompiler
     *
     * @return \Illuminate\View\Compilers\BladeCompiler
     */
    public function getBladeCompiler()
    {
        return $this->view->getEngineResolver()->resolve('blade')->getCompiler();
    }

    /**
     * Get the value of view
     *
     * @return \Illuminate\View\Factory
     */
    public function getViewFactory()
    {
        return $this->view;
    }

    /**
     * Sets the value of view
     *
     * @param \Illuminate\View\Factory $view
     * @return $this
     */
    public function setViewFactory($view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Get the value of sections
     *
     * @return \Radic\BladeExtensions\Helpers\Sections
     */
    public function getSections()
    {
        return $this->sections;
    }

    /**
     * Sets the value of sections
     *
     * @param \Radic\BladeExtensions\Helpers\Sections $sections
     * @return $this
     */
    public function setSections($sections)
    {
        $this->sections = $sections;

        return $this;
    }

    /**
     * Get the value of widgets
     *
     * @return Widget[]
     */
    public function getWidgets()
    {
        return $this->widgets;
    }

    /**
     * Get the value of widgetClasses
     *
     * @return \string[]
     */
    public function getWidgetClasses()
    {
        return $this->widgetClasses;
    }

    /**
     * Sets the value of widgetClasses
     *
     * @param \string[] $widgetClasses
     * @return \string[]
     */
    public function setWidgetClasses($widgetClasses)
    {
        $this->widgetClasses = $widgetClasses;

        return $this;
    }



}
