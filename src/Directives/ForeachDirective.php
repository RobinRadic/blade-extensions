<?php
/**
 * Copyright (c) 2016. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2016 (c) Robin Radic
 * @license https://radic.mit-license.org The MIT License
 */

namespace Radic\BladeExtensions\Directives;

class ForeachDirective extends Directive
{
    protected $pattern = '/(?<!\\w)(\\s*)@NAME(?:\\s*)\\((.*)(?:\\sas)(.*)\\)/';

    protected $replace = <<<'EOT'
$1<?php
app('blade-extensions.helpers')->get('loop')->newLoop($2);
foreach(app('blade-extensions.helpers')->get('loop')->getLastStack()->getItems() as $3):
    $loop = app('blade-extensions.helpers')->get('loop')->loop();
?>
EOT;


}
