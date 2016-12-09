<?php
namespace Radic\BladeExtensions\Directives;

class BreakpointDirective extends Directive
{

    protected $replace = '$1<?php if(function_exists("xdebug_break")){ xdebug_break(); } ?>$2';


}
