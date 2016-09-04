<?php
namespace Radic\BladeExtensions\Seven\Directives;

class UnsetDirective extends Directive
{
    protected $pattern = '/(?<!\\w)(\\s*)@NAME(?:\\s*)\\((?:\\s*)(?:\\$|(?:\'|\\"|))(.*?)(?:\'|\\"|)(?:\\s*)\\)/';

    protected $replace = '$1<?php unset(\$$2); ?>';


}
