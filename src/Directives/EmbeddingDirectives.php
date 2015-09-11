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
     * embedView
     *
     * @param                                              $value
     * @param                                              $configured
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Illuminate\View\Compilers\BladeCompiler     $blade
     * @return mixed
     */
    public function embedView($value, $configured, Application $app, Compiler $blade)
    {
        $pattern = '/(?<!\w)(\s*)@embed\s*\((.*?)\)$((?>(?!@(?:end)?embed).|(?0))*)@endembed/sm';

        $replacement = str_replace('\\EOT_', 'EOT_', <<<'EOT'
$1<?php app('blade.helpers')->get('embed')->start($2)->setData($__data); ?>
$1<?php app('blade.helpers')->get('embed')->current()->setContent(<<<'EOT_'
$3
\EOT_
); ?>
$1<?php app('blade.helpers')->get('embed')->end(); ?>
EOT
        );

        $replacement = str_replace('EOT_', 'EOT_' . uniqid('embed', false), $replacement);

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
