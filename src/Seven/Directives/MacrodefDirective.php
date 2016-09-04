<?php
namespace Radic\BladeExtensions\Seven\Directives;

class MacrodefDirective extends Directive
{
    protected $pattern = '/(?<!\w)(\s*)@macrodef(?:\s*)\((?:\s*)[\'"]([\w\d]*)[\'"](?:,|)(.*)\)/';

    protected $replace = '$1<?php app("blade.helpers")->macro("$2", function($3){ ?>';

}
