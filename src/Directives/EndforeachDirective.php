<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2017 (c) Robin Radic
 * @license https://radic.mit-license.org The MIT License
 */

namespace Radic\BladeExtensions\Directives;

class EndforeachDirective extends Directive
{
    protected $replace = <<<'EOT'
$1<?php
app('blade-extensions.helpers')->get('loop')->looped();
endforeach;
app('blade-extensions.helpers')->get('loop')->endLoop($loop);
?>$2
EOT;
}
