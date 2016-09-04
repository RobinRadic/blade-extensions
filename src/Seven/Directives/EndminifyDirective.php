<?php
namespace Radic\BladeExtensions\Seven\Directives;

class EndminifyDirective extends Directive
{
    protected $pattern = '/(?<!\\w)(\\s*)@NAME(\\s*)/';

    protected $replace = <<<'EOT'
$1<?php echo app("blade.helpers")->get('minifier')->close(); ?>
EOT;

}
