<?php
namespace Radic\BladeExtensions\Directives;

class EndmarkdownDirective extends Directive
{
    protected $replace = "$1\nEOT\n); ?>$2";

}
