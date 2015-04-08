<?php
/**
 * Part of the Laradic packages.
 */
namespace Radic\BladeExtensions\Widgets;

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

    protected $widgets = [];

    /**
     * Instantiates the class
     */
    public function __construct(Sections $sections)
    {
        $this->sections = $sections;
    }

    public function create($name)
    {
        return $this->widgets[$name] = new Widget($this, $name);
    }

    public function startWidget($name)
    {
        $this->sections->startSection("widget.$name");
    }

    public function stopWidget()
    {
        $this->sections->stopSection();
    }

    public function render($name)
    {
        if ( ! $this->has($name) )
        {
            return null;
        }
        $widget = $this->get($name);
        return $this->sections->yieldContent("widget.$name");
    }

    /**
     * get
     *
     * @param $name
     * @return null|Widget
     */
    public function get($name)
    {
        if ( ! $this->has($name) )
        {
            return null;
        }

        return $this->widgets[$name];
    }

    public function has($name)
    {
        return isset($this->widgets[$name]);
    }
}
