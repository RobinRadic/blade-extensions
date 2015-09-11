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
class Embedding2Directives
{
    use BladeExtenderTrait;

    /**
     * the addPartial
     *
     * @param                                          $value
     * @param                                          $configured
     * @param \Illuminate\Foundation\Application       $app
     * @param \Illuminate\View\Compilers\BladeCompiler $blade
     * @return mixed
     */
    public function embedView($value, $configured, Application $app, Compiler $blade)
    {
        $pattern = '/(?<!\w)(\s*)@embed\s*\((.*?)\)$((?>(?!@(?:end)?embed).|(?0))*)@endembed/sm';

        /*$pattern = '/@embed\\s*\\([^)]*\\)((?>(?!@(?:end)?embed).|(?0))*)@endembed/s';
        //$pattern = '/(?<!\w)(\s*)@embed\s*\(([^)]*)\)((?>(?!@(?:end)?embed).|(?0))*)@endembed/s';*/

        $replacement = str_replace('\\EOT_', 'EOT_', <<<'EOT'
$1<?php app('blade.embedding')->start($2)->setData($__data); ?>
$1<?php app('blade.embedding')->current()->setContent(<<<'EOT_'
$3
\EOT_
); ?>
$1<?php app('blade.embedding')->end(); ?>
EOT
        );
        // $1<?php if(app('blade.embedding')->isEmpty()){ $__env = $__data['__env']; } else { $__env = app('blade.embedding')->current(); }

        $replacement = str_replace('EOT_', 'EOT_' . uniqid('embed', false), $replacement);

        $replacement2 = str_replace('\\EOT', 'EOT', <<<'EOT'
$1<?php $__env = app('blade.embedding')->start($2); ?>
$3
$1<?php app('blade.embedding')->end(); ?>
$1<?php if(app('blade.embedding')->isEmpty()){ $__env = $__data['__env']; } else { $__env = app('blade.embedding')->current(); } ?>
EOT
        );


        $res = array();
        $str = $value;
        while (preg_match_all($pattern, $str, $out))
        {
            $replacement = str_replace('EOT_', 'EOT_' . uniqid('embed' . md5($str), false), $replacement);
            $str = preg_replace($pattern, $replacement, $str);
            $res = array_merge($res, $out[1]);
        }


        return $str; //preg_replace($pattern, $replacement, $value);

        return str_replace('\\EOT', 'EOT', preg_replace($pattern, <<<'EOT'
$1<?php app('blade.embedding')->open($2)->insert(<<<'EOT'
$3
\EOT
        )->close(); ?>
EOT
            , $value));
        /*
                $res = array();
                $str = $value;
                while (preg_match_all($pattern, $str, $out)) {

                    $replacement =  str_replace('\\EOT_', 'EOT_', <<<'EOT'
        $1<?php app('blade.embedding')->open($2)->insert(<<<'EOT_'
        $3
        \EOT_
        ); ?>
        $1<?php app('blade.embedding')->close(); ?>
        EOT
                    );
                    $replacement = str_replace('EOT_', 'EOT_' . uniqid('embed', false), $replacement);

                    $str = preg_replace($pattern, $replacement, $str);
                    $res = array_merge($res, $out[1]);
                }

                return $str;
            }*/
    }
}
