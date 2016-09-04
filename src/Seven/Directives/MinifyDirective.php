<?php
namespace Radic\BladeExtensions\Seven\Directives;

class MinifyDirective extends Directive
{
    protected $pattern = '/(?<!\\w)(\\s*)@minify(\\s*\\(.*\\))/';

    protected $replace = <<<'EOT'
$1<?php echo app("blade.helpers")->get('minifier')->open$2; ?>
EOT;


}
