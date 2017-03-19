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

use Radic\BladeExtensions\Helpers\BladeMatchers;

/**
 * This is the class IfSectionDirective.
 *
 * @package Radic\BladeExtensions\Directives
 * @author  Robin Radic
 */
class IfSectionDirective extends AbstractDirective
{
    /** @var string */
    protected $replace = '$1<?php if( $__env->hasSection$2 ) : ?>$3';


    /**
     * getPattern method
     *
     * @return string
     */
    public function getPattern()
    {
        return BladeMatchers::$createMatcher;
    }

}
