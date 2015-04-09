<?php
/**
 * Directives: partial, endpartial, block, endblock, render
 */
namespace Radic\BladeExtensions\Directives;

use Illuminate\Foundation\Application;
use Illuminate\View\Compilers\BladeCompiler as Compiler;
use Radic\BladeExtensions\Traits\BladeExtenderTrait;

/**
 * Directives: partial, endpartial, block, endblock, render
 *
 * @package            Radic\BladeExtensions
 * @subpackage         Directives
 * @version            2.1.0
 * @author             Robin Radic
 * @license            MIT License - http://radic.mit-license.org
 * @copyright          2011-2015, Robin Radic
 * @link               http://robin.radic.nl/blade-extensions
 *
 */
class WidgetDirectives
{
    use BladeExtenderTrait;

    /**
     * the addPartial
     * @param             $value
     * @param             $configured
     * @param \Illuminate\Foundation\Application $app
     * @param \Illuminate\View\Compilers\BladeCompiler $blade
     * @return mixed
     */
    public function openWidget($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = $blade->createMatcher('widget');

        return preg_replace($matcher, $configured, $value);
    }

    /**
     * the endPartial
     * @param             $value
     * @param             $configured
     * @param \Illuminate\Foundation\Application $app
     * @param \Illuminate\View\Compilers\BladeCompiler $blade
     * @return mixed
     */
    public function closeWidget($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = $blade->createPlainMatcher('endwidget');

        return preg_replace($matcher, $configured, $value);
    }

    /**
     * the startWidgetBlock
     * @param             $value
     * @param             $configured
     * @param \Illuminate\Foundation\Application $app
     * @param \Illuminate\View\Compilers\BladeCompiler $blade
     * @return mixed
     */
    public function startWidgetBlock($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = $blade->createMatcher('block');

        return preg_replace($matcher, $configured, $value);
    }

    /**
     * the stopWidgetBlock
     * @param             $value
     * @param             $configured
     * @param \Illuminate\Foundation\Application $app
     * @param \Illuminate\View\Compilers\BladeCompiler $blade
     * @return mixed
     */
    public function stopWidgetBlock($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = $blade->createMatcher('endblock');

        return preg_replace($matcher, $configured, $value);
    }

    /**
     * the renderWidgetBlock
     * @param             $value
     * @param             $configured
     * @param \Illuminate\Foundation\Application $app
     * @param \Illuminate\View\Compilers\BladeCompiler $blade
     * @return mixed
     */
    public function renderWidgetBlock($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = $blade->createMatcher('render');

        return preg_replace($matcher, $configured, $value);
    }

}
