<?php
namespace Radic\BladeExtensions\Seven\Directives;

class BreakpointDirective extends Directive
{
    protected $pattern = '/(?<!\\w)(\\s*)@NAME(\\s*)/';

    protected $replace = <<<'EOT'
<!-- breakpoint --><?php
if(function_exists('xdebug_break')){
    var_dump(xdebug_break());
}
?>
EOT;


}
