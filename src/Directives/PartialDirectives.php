<?php
/**
 * Directives: partial, endpartial, block, endblock, render
 */
namespace Radic\BladeExtensions\Directives;

use Illuminate\Contracts\Foundation\Application;
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
class PartialDirectives
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
    public function addPartial($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = $blade->createOpenMatcher('partial');

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
    public function endPartial($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = $blade->createPlainMatcher('endpartial');

        return preg_replace($matcher, $configured, $value);
    }

    /**
     * the openBlock
     * @param             $value
     * @param             $configured
     * @param \Illuminate\Foundation\Application $app
     * @param \Illuminate\View\Compilers\BladeCompiler $blade
     * @return mixed
     */
    public function openBlock($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = $blade->createMatcher('block');

        return preg_replace($matcher, $configured, $value);
    }

    /**
     * the endBlock
     * @param             $value
     * @param             $configured
     * @param \Illuminate\Foundation\Application $app
     * @param \Illuminate\View\Compilers\BladeCompiler $blade
     * @return mixed
     */
    public function endBlock($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = $blade->createPlainMatcher('endblock');

        return preg_replace($matcher, $configured, $value);
    }

    /**
     * the addRender
     * @param             $value
     * @param             $configured
     * @param \Illuminate\Foundation\Application $app
     * @param \Illuminate\View\Compilers\BladeCompiler $blade
     * @return mixed
     */
    public function addRender($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = $blade->createMatcher('render');

        return preg_replace($matcher, $configured, $value);
    }
}
