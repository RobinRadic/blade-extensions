<?php
namespace Radic\BladeExtensions\Seven\Directives;

class BreakDirective extends Directive
{
    protected $pattern = '/(?<!\\w)(\\s*)@NAME(\\s*)/';

    protected $replace = '$1<?php break; ?>$2';


}
