<?php
/**
 * Directives: partial, endpartial, block, endblock, render
 */
namespace Radic\BladeExtensions\Directives;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\View\Compilers\BladeCompiler as Compiler;
use Radic\BladeExtensions\Traits\BladeExtenderTrait;

/**
 * Directives: partial, endpartial, block, endblock, render
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
class EmbeddingDirectives
{
    use BladeExtenderTrait;

    /**
     * directiveEmbed
     *
     * @param                                              $value
     * @param                                              $pattern
     * @param                                              $replacement
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Illuminate\View\Compilers\BladeCompiler     $blade
     * @return mixed
     */
    public function directiveEmbed($value, $pattern, $replacement, Application $app, Compiler $blade)
    {
        $replacement = str_replace('\\EOT_', 'EOT_', $replacement);
        #$replacement = str_replace('EOT_', 'EOT_' . uniqid('embed', false), $replacement);

        $res = array();
        $str = $value;
        while (preg_match_all($pattern, $str, $out)) {
            $replacement = str_replace('EOT_', 'EOT_' . uniqid('embed' . md5($str), false), $replacement);
            $str = preg_replace($pattern, $replacement, $str);
            $res = array_merge($res, $out[1]);
        }


        return $str;
    }
}
