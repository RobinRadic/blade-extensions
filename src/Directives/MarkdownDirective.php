<?php namespace Radic\BladeExtensions\Directives;

use Illuminate\Foundation\Application;
use Illuminate\View\Compilers\BladeCompiler as Compiler;
use Radic\BladeExtensions\Traits\BladeExtenderTrait;

/**
 * Markdown directives
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
class MarkdownDirective
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
        $matcher = '/@markdown([\w\W]*?)@endmarkdown/';
        #var_dump($value);

        preg_match_all($matcher, $value, $matches);
        #var_dump();

        if(isset($matches[1][0])){
            $parsedown = new \Parsedown();
            return $parsedown->text($matches[1][0]);
        }
        return $value;
        //return preg_replace('', '', $value);
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


}
