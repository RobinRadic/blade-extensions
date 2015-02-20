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
        //$matcher = '/@markdown([\w\W]*?)@endmarkdown/';
        //preg_match_all($matcher, $value, $matches);
        $replace = preg_replace($blade->createPlainMatcher('markdown'), "$1<?php echo \Radic\BladeExtensions\Helpers\Markdown::parse(<<<'EOT'$2", $value);
        return $replace;

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
        return preg_replace($blade->createPlainMatcher('endmarkdown'), "$1\nEOT\n); ?>$2", $value);
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
