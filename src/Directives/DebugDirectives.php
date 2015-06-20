<?php
/**
 * Directives: breakpoint, debug
 */
namespace Radic\BladeExtensions\Directives;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\View\Compilers\BladeCompiler as Compiler;
use Radic\BladeExtensions\Traits\BladeExtenderTrait;

/**
 * Directives: breakpoint, debug
 * @package                    Radic\BladeExtensions
 * @subpackage                 Directives
 * @version                    2.1.0
 * @author                     Robin Radic
 * @license                    MIT License - http://radic.mit-license.org
 * @copyright                  2011-2015, Robin Radic
 * @link                       http://robin.radic.nl/blade-extensions
 */
class DebugDirectives
{
    use BladeExtenderTrait;


    /**
     * Adds `breakpoint` directive
     *
     * @param             $value
     * @param             $configured
     * @param Application $app
     * @param Compiler $blade
     * @return mixed
     */
    public function addBreakpoint($value, $configured, Application $app, Compiler $blade)
    {
        $matcher    =  $this->createPlainMatcher('breakpoint');
        return preg_replace($matcher, $configured, $value);
    }

    /**
     * Adds `debug` directive
     *
     * @param             $value
     * @param             $configured
     * @param Application $app
     * @param Compiler $blade
     * @return mixed
     */
    public function addDebug($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = '/(?<!\w)(\s*)@debug(?:\s*)\((?:\s*)([^()]+)*\)/';
        return preg_replace($matcher, $configured, $value);
    }
}
