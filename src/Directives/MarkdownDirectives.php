<?php
/**
 * Directives: markdown, endmarkdown
 */
namespace Radic\BladeExtensions\Directives;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\View\Compilers\BladeCompiler as Compiler;
use Radic\BladeExtensions\Traits\BladeExtenderTrait;

/**
 * Directives: markdown, endmarkdown
 *
 * @package            Radic\BladeExtensions
 * @subpackage         Directives
 * @version            2.1.0
 * @author             Robin Radic
 * @license            MIT License - http://radic.mit-license.org
 * @copyright          2011-2015, Robin Radic
 * @link               http://robin.radic.nl/blade-extensions
 */
class MarkdownDirectives
{
    use BladeExtenderTrait;

    /**
     * directiveMarkdown
     *
     * @param                                              $value
     * @param                                              $pattern
     * @param                                              $replacement
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Illuminate\View\Compilers\BladeCompiler     $blade
     * @return mixed
     */
    public function directiveMarkdown($value, $pattern, $replacement, Application $app, Compiler $blade)
    {
        return preg_replace($pattern, $replacement, $value);
    }

    /**
     * directiveEndmarkdown
     *
     * @param                                              $value
     * @param                                              $pattern
     * @param                                              $replacement
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Illuminate\View\Compilers\BladeCompiler     $blade
     * @return mixed
     */
    public function directiveEndmarkdown($value, $pattern, $replacement, Application $app, Compiler $blade)
    {
        return preg_replace($pattern, $replacement, $value);
    }
}
