<?php
namespace Radic\BladeExtensions\Directives;

class ForeachDirective extends Directive
{
    protected $pattern = '/(?<!\\w)(\\s*)@NAME(?:\\s*)\\((.*)(?:\\sas)(.*)\\)/';

    protected $replace = <<<'EOT'
$1<?php
app('blade.helpers')->get('loop')->newLoop($2);
foreach(app('blade.helpers')->get('loop')->getLastStack()->getItems() as $3):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
EOT;


}
