<?php
namespace Radic\BladeExtensions\Seven\Directives;

class EndmarkdownDirective extends Directive
{
    protected $pattern = '/(?<!\\w)(\\s*)@endmarkdown(\\s*)/';

    protected $replace = "$1\nEOT\n); ?>$2";


}
