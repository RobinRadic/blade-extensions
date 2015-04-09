<?php
/**
 * Part of the Laradic packages.
 */
namespace Radic\BladeExtensions\Widgets;

use Radic\BladeExtensions\Contracts\Widget as WidgetContract;
use Radic\BladeExtensions\Traits\SectionsTrait;

/**
 * Class Widget
 *
 * @package     Radic\BladeExtensions\Widgets
 * @author      Robin Radic
 * @license     MIT
 * @copyright   2011-2015, Robin Radic
 * @link        http://radic.mit-license.org
 */
abstract class Widget implements WidgetContract
{
    use SectionsTrait;

    protected $name;

    protected $factory;

    protected $vars = [];

    /**
     * Instantiates the class
     *
     * @param \Radic\BladeExtensions\Widgets\Factory $factory
     * @param                                        $name
     */
    public function __construct(Factory $factory, $name)
    {
        $this->factory = $factory;
        $this->name    = $name;
        $this->setViewFactory($factory->getViewFactory());
        $this->set('__widget', $this);
    }

    abstract public function run();

    abstract public function getName();

    abstract public function getViewName();

    public function with(array $params = array())
    {
        $this->vars = array_merge($this->vars, $params);
    }

    public function set($key, $val = null)
    {
        if ( is_array($key) )
        {
            foreach ($key as $k => $v)
            {
                $this->set($k, $v);
            }
        }
        else
        {
            array_set($this->vars, $key, $val);
        }

        return $this;
    }

    public function get($key)
    {
        return array_get($this->vars, $key);
    }

    public static function make(Factory $factory, $name)
    {
        return new static($factory, $name);
    }

    public function startContent()
    {
        ob_start();
    }

    public function stopContent()
    {
        $c = ob_get_contents();
        ob_end_clean();
        $this->set('content', $c);
    }

    public function block($name, $value)
    {
        $this->inject($name, $value);
    }

    /**
     * getView
     *
     * @param array $params
     * @return \Illuminate\View\View
     */
    public function getView(array $params = array())
    {
        $view = $this->getViewFactory()
            ->make($this->getViewName())
            ->with($this->vars);
        return $view;
    }
}
