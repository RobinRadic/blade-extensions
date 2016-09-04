<?php
namespace Radic\BladeExtensions\Seven\Directives;

class ContinueDirective extends Directive
{
    protected $pattern = '/(?<!\w)(\s*)@NAME\s*\(\s*\${0,1}[\'"\s]*(.*?)[\'"\s]*,\s*([\W\w^]*?)\)\s*$/m';

    protected $replace = <<<'EOT'
$1<?php
app('blade.helpers')->get('loop')->looped();
continue;
?>$2
EOT;

}
