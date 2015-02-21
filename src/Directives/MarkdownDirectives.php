<?php namespace Radic\BladeExtensions\Directives;

use Illuminate\Foundation\Application;
use Illuminate\View\Compilers\BladeCompiler as Compiler;
use Radic\BladeExtensions\Traits\BladeExtenderTrait;


/**
 * Directives: markdown, endmarkdown
 *
 * @package            Radic\BladeExtensions
 * @version            2.1.0
 * @subpackage         Directives
 * @author             Robin Radic
 * @license            MIT License - http://radic.mit-license.org
 * @copyright          (c) 2011-2015, Robin Radic
 * @link               http://robin.radic.nl/blade-extensions
 *
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
        $matcher = $blade->createPlainMatcher('endmarkdown');

        return preg_replace($matcher, $configured, $value);
    }

    /**
     * Adds include markdown file
     *
     * @param             $value
     * @param             $configured
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function includeMarkdown($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = '/@markdown(?>\(\')(.*?)\'\)/'; # positive lookahead, cuts out the quoted part
        $replace = '<?php include("$1"); ?>';
        return preg_replace($matcher, $replace, $value);
    }
    /*
     *
        if(isset($matches[1][0])){
            $parsedown = new \Parsedown();
            $text = $parsedown->text($matches[1][0]); //preg_replace($matcher, 'asdf', $value);
            return $text;
        }
        return $value;
        //return preg_replace('', '', $value);
     */
}
