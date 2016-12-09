<?php
namespace Radic\BladeExtensions\Directives;

class EndminifyDirective extends Directive
{
    protected $replace = <<<'EOT'
$1<?php echo app("blade.helpers")->get('minifier')->close(); ?>
EOT;

}
