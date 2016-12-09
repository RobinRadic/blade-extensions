<?php
namespace Radic\BladeExtensions\Directives;

class EndmacroDirective extends Directive
{
    protected $pattern = '/(?<!\w)(\s*)@NAME\s*\(\s*\${0,1}[\'"\s]*(.*?)[\'"\s]*,\s*([\W\w^]*?)\)\s*$/m';

    protected $replace = '$1<?php }); ?>$2';

}
