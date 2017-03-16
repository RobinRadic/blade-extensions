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

/**
 * This is the class EndspacelessDirective.
 *
 * @author  Robin Radic
 */
class EndspacelessDirective extends AbstractDirective
{
    protected $replace = '<?php echo preg_replace(\'/>\\s+</\', \'><\', ob_get_clean()); ?>';
}
