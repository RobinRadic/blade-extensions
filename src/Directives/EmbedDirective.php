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

use Illuminate\Contracts\Container\Container;
use Radic\BladeExtensions\Contracts\HelperRepository;

/**
 * This is the class EmbedDirective.
 *
 * @author  Robin Radic
 */
class EmbedDirective extends AbstractDirective
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

    /**
     * DumpDirective constructor.
     */
    public function __construct(HelperRepository $helpers, Container $container)
    {
        $helpers->put('embed', $container->make(\Radic\BladeExtensions\Helpers\Embed\EmbedHelper::class));
    }
}
