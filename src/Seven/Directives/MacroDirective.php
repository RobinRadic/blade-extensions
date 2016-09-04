<?php
namespace Radic\BladeExtensions\Seven\Directives;

class MacroDirective extends Directive
{
    protected $pattern = '/(?<!\\w)(\\s*)@NAME(?:\\s*)\\((?:\\s*)[\'"]([\\w\\d]*)[\'"](?:,|)(.*)\\)/';

    protected $replace = '$1<?php echo app("blade.helpers")->$2($3); ?>';

}
