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
     * the addPartial
     * @param             $value
     * @param             $configured
     * @param \Illuminate\Foundation\Application $app
     * @param \Illuminate\View\Compilers\BladeCompiler $blade
     * @return mixed
     */
    public function embedView($value, $configured, Application $app, Compiler $blade)
    {
        $pattern = '/(?<!\w)(\s*)@embed\s*(\([^)]*\))((?>(?!@(?:end)?embed).|(?0))*)@endembed/s';

        return str_replace('\\EOT', 'EOT', preg_replace($pattern, <<<'EOT'
$1<?php app('blade.embedding')->open$2->insert(<<<'EOT'
$3
\EOT
        )->close(); ?>
EOT
        , $value));
    }
}
