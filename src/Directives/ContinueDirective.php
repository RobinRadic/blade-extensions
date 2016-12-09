<?php
namespace Radic\BladeExtensions\Directives;

class ContinueDirective extends Directive
{

    protected $replace = '$1<?php app("blade.helpers")->get("loop")->looped(); continue; ?>$2';
}
