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
 * This is the class EndforeachDirective.
 *
 * @author  Robin Radic
 */
class EndforeachDirective extends AbstractDirective
{
    public static $compatibility = '5.0.*|5.1.*|5.2.*';

    protected $replace = <<<'EOT'
$1<?php
app('blade-extensions.helpers')->get('loop')->looped();
endforeach;
app('blade-extensions.helpers')->get('loop')->endLoop($loop);
?>$2
EOT;
}
