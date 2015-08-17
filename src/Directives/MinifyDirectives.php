<?php
/**
 * Directives: set, unset
 */
namespace Radic\BladeExtensions\Directives;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\View\Compilers\BladeCompiler as Compiler;
use Radic\BladeExtensions\Traits\BladeExtenderTrait;

/**
 * Directives: set, unset
 * @package                Radic\BladeExtensions
 * @subpackage             Directives
 * @version                2.1.0
 * @author                 Robin Radic
 * @license                MIT License - http://radic.mit-license.org
 * @copyright              2011-2015, Robin Radic
 * @link                   http://robin.radic.nl/blade-extensions
 */
class MinifyDirectives
{
    use BladeExtenderTrait;

    /**
     * Adds `set` directive
     *
     * @param             $value
     * @param             $configured
     * @param Application $app
     * @param Compiler $blade
     * @return mixed
     */
    public function openMinify($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = $this->createMatcher('minify');

        return preg_replace($matcher, $configured, $value);
    }

    /**
     * Adds `unset` directive
     *
     * @param             $value
     * @param             $configured
     * @param Application $app
     * @param Compiler $blade
     * @return mixed
     */
    public function closeMinify($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = $this->createPlainMatcher('endminify');

        return preg_replace($matcher, $configured, $value);
    }
}
