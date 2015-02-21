<?php namespace Radic\BladeExtensions\Directives;

use Illuminate\Foundation\Application;
use Illuminate\View\Compilers\BladeCompiler as Compiler;
use Radic\BladeExtensions\Traits\BladeExtenderTrait;

/**
 * Partials directives
 *
 * @package        Radic\BladeExtensions
 * @subpackage     Directives
 * @version        2.0.0
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2014, Robin Radic - Radic Technologies
 * @link           http://robin.radic.nl/blade-extensions
 *
 */
class PartialDirective
{
    use BladeExtenderTrait;

    /**
     * @param             $value
     * @param             $configured
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function addPartial($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = $blade->createOpenMatcher('partial');

        return preg_replace($matcher, $configured, $value);
    }

    /**
     * @param             $value
     * @param             $configured
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function endPartial($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = $blade->createPlainMatcher('endpartial');

        return preg_replace($matcher, $configured, $value);
    }

    /**
     * @param             $value
     * @param             $configured
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function openBlock($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = $blade->createMatcher('block');

        return preg_replace($matcher, $configured, $value);
    }

    /**
     * @param             $value
     * @param             $configured
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function endBlock($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = $blade->createPlainMatcher('endblock');

        return preg_replace($matcher, $configured, $value);
    }

    /**
     * @param             $value
     * @param             $configured
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function addRender($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = $blade->createMatcher('render');

        return preg_replace($matcher, $configured, $value);
    }
}
