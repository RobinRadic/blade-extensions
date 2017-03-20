<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright 2017 Robin Radic
 * @license https://radic.mit-license.org MIT License
 * @version 7.0.0 Radic\BladeExtensions
 */

namespace Radic\BladeExtensions\Directives;

use Radic\BladeExtensions\Contracts\HelperRepository;

/**
 * This is the class DumpDirective.
 *
 * @author  Robin Radic
 */
class DumpDirective extends AbstractDirective
{
    protected $pattern = self::OPEN_MATCHER;

    protected $replace = <<<'EOT'
    $1<?php 
    app('blade-extensions.helpers')
        ->get('dump')
        ->setPath(isset($__path) ? $__path : null)
        ->setEnv($__env)
        ->setVars(array_except(get_defined_vars(), ['__data', '__path']))        
        ->dump$2 
    ?>$3
EOT;

    /**
     * DumpDirective constructor.
     */
    public function __construct(HelperRepository $helpers)
    {
        $helpers->put('dump', new \Radic\BladeExtensions\Helpers\DumpHelper());
    }
}
