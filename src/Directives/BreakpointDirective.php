<?php
namespace Radic\BladeExtensions\Directives;

class BreakpointDirective extends Directive
{
    protected $pattern = '/(?<!\\w)(\\s*)@NAME(\\s*)/';

    protected $replace = '<?php if(function_exists("xdebug_break")){ xdebug_break(); } ?>';


}
