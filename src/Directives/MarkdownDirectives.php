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
     * Starts `Markdown` directive
     *
     * @param             $value
     * @param             $configured
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function openMarkdown($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = '/(?<!\w)(\s*)@markdown(?!\()(\s*)/'; # matcher with negative lookahead, so ignores @markdown(...  includes
        //$configured = "$1<? echo app()->make('markdown')->render(<<<'EOT'$2";
        //$blade->createOpenMatcher()
        return preg_replace($matcher, $configured, $value);
    }

    /**
     * Ends `Markdown` directive
     *
     * @param             $value
     * @param             $directive
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function closeMarkdown($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = $this->createPlainMatcher('endmarkdown');

        return preg_replace($matcher, $configured, $value);
    }
}
