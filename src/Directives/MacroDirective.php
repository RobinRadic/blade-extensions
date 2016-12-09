<?php
namespace Radic\BladeExtensions\Directives;

class MacroDirective extends Directive
{
    protected $pattern = '/(?<!\\w)(\\s*)@NAME(?:\\s*)\\((?:\\s*)[\'"]([\\w\\d]*)[\'"](?:,|)(.*)\\)/';

    protected $replace = '$1<?php echo app("blade.helpers")->$2($3); ?>';

}
