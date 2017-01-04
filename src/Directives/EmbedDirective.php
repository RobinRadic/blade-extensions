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

class EmbedDirective extends Directive
{
    protected $pattern = '/(?<!\\w)(\\s*)@NAME\\s*\\((.*?)\\)\\s*$((?>(?!@(?:end)?NAME).|(?0))*)@endNAME/sm';

    protected $replace = <<<'EOT'
$1<?php app('blade-extensions.helpers')->get('embed')->start($2); ?>
$1<?php app('blade-extensions.helpers')->get('embed')->current()->setData(\$__data)->setContent(<<<'EOT_'
$3
\EOT_
); ?>
$1<?php app('blade-extensions.helpers')->get('embed')->end(); ?>
EOT;

}
