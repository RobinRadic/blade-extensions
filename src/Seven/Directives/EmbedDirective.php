<?php
namespace Radic\BladeExtensions\Seven\Directives;

class EmbedDirective extends Directive
{
    protected $pattern = '/(?<!\\w)(\\s*)@NAME\\s*\\((.*?)\\)\\s*$((?>(?!@(?:end)?NAME).|(?0))*)@endNAME/sm';

    protected $replace = <<<'EOT'
$1<?php app('blade.helpers')->get('embed')->start($2); ?>
$1<?php app('blade.helpers')->get('embed')->current()->setData(\$__data)->setContent(<<<'EOT_'
$3
\EOT_
); ?>
$1<?php app('blade.helpers')->get('embed')->end(); ?>
EOT;

}
