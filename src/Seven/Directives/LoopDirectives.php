<?php
/**
 * Directives: foreach, endforeach, break, continue
 */
namespace Radic\BladeExtensions\Seven\Directives;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\View\Compilers\BladeCompiler as Compiler;

/**
 * Directives: foreach, endforeach, break, continue
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
class LoopDirectives
{

    /**
     * directiveForeach
     *
     * @param                                              $value
     * @param                                              $pattern
     * @param                                              $replacement
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Illuminate\View\Compilers\BladeCompiler     $blade
     *
     * @return mixed
     */
    public function foreachDirective($value, $pattern, $replacement, Application $app, Compiler $blade)
    {
        return preg_replace($pattern, $replacement, $value);
    }

    /**
     * directiveEndforeach
     *
     * @param                                              $value
     * @param                                              $pattern
     * @param                                              $replacement
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Illuminate\View\Compilers\BladeCompiler     $blade
     *
     * @return mixed
     */
    public function endforeachDirective($value, $pattern, $replacement, Application $app, Compiler $blade)
    {
        return preg_replace($pattern, $replacement, $value);
    }

    /**
     * directiveBreak
     *
     * @param                                              $value
     * @param                                              $pattern
     * @param                                              $replacement
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Illuminate\View\Compilers\BladeCompiler     $blade
     *
     * @return mixed
     */
    public function breakDirective($value, $pattern, $replacement, Application $app, Compiler $blade)
    {
        return preg_replace($pattern, $replacement, $value);
    }

    /**
     * directiveContinue
     *
     * @param                                              $value
     * @param                                              $pattern
     * @param                                              $replacement
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Illuminate\View\Compilers\BladeCompiler     $blade
     *
     * @return mixed
     */
    public function continueDirective($value, $pattern, $replacement, Application $app, Compiler $blade)
    {
        return preg_replace($pattern, $replacement, $value);
    }
}
