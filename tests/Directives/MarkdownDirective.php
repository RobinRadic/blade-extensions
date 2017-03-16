<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright 2017 Robin Radic
 * @license https://radic.mit-license.org MIT License
 * @version 7.0.0
 */

namespace Radic\BladeExtensions\Directives;

class MarkdownAbstractDirective extends AbstractDirective
{
    protected $pattern = '/(?<!\\w)(\\s*)@markdown(?!\\()(\\s*)/';

    protected $replace = <<<'EOT'
$1<?php echo app("blade.helpers")->get('markdown')->parse(<<<'EOT'$2
EOT;
}
