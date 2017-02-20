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

class ForeachDirective extends Directive
{
    public static $compatibility = '5.0.*|5.1.*|5.2.*';

    protected $pattern = '/(?<!\\w)(\\s*)@NAME(?:\\s*)\\((.*)(?:\\sas)(.*)\\)/';

    protected $replace = <<<'EOT'
$1<?php
app('blade-extensions.helpers')->get('loop')->newLoop($2);
foreach(app('blade-extensions.helpers')->get('loop')->getLastStack()->getItems() as $3):
    $loop = app('blade-extensions.helpers')->get('loop')->loop();
?>
EOT;
}
