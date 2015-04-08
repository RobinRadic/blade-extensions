<?php
/**
 * Part of the Laradic packages.
 */
namespace Radic\BladeExtensions\Widgets;

use Radic\BladeExtensions\Traits\BladeSections;

/**
 * Class Widget
 *
 * @package     Radic\BladeExtensions\Widgets
 * @author      Robin Radic
 * @license     MIT
 * @copyright   2011-2015, Robin Radic
 * @link        http://radic.mit-license.org
 */
class Widget
{
    use BladeSections;

    protected $name;

    protected $factory;

    /**
     * Instantiates the class
     */
    public function __construct(Factory $factory, $name)
    {
        $this->name = $name;
    }

    public function getName()
    {
        return $this->name;
    }
}
