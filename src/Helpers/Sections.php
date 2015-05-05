<?php
/**
 * Part of the Laradic packages.
 */
namespace Radic\BladeExtensions\Helpers;

use Illuminate\Contracts\View\Factory;
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
class Sections
{
    use SectionsTrait;

    public function __construct(Factory $view)
    {
        $this->setViewFactory($view);
    }
}
