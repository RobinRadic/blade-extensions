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
     * directiveBreakpoint
     *
     * @param                                              $value
     * @param                                              $pattern
     * @param                                              $replacement
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Illuminate\View\Compilers\BladeCompiler     $blade
     * @return mixed
     */
    public function directiveBreakpoint($value, $pattern, $replacement, Application $app, Compiler $blade)
    {
        return preg_replace($pattern, $replacement, $value);
    }

    /**
     * directiveDebug
     *
     * @param                                              $value
     * @param                                              $pattern
     * @param                                              $replacement
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Illuminate\View\Compilers\BladeCompiler     $blade
     * @return mixed
     */
    public function directiveDebug($value, $pattern, $replacement, Application $app, Compiler $blade)
    {
        return preg_replace($pattern, $replacement, $value);
    }
}
