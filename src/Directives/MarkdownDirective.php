<?php
namespace Radic\BladeExtensions\Directives;

class MarkdownDirective extends Directive
{
    protected $pattern = '/(?<!\\w)(\\s*)@NAME(?!\\()(\\s*)/';

    protected $replace = <<<'EOT'
$1<?php echo app("blade.helpers")->get('markdown')->parse(<<<'EOT'$2
EOT;


}
