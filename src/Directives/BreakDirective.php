<?php
namespace Radic\BladeExtensions\Directives;

class BreakDirective extends Directive
{

    protected $replace = '$1<?php break; ?>$2';


}
