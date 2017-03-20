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
use Radic\BladeExtensions\Helpers\Minifier\MinifierHelper;

/**
 * This is the class MinifyDirective.
 *
 * @author  Robin Radic
 */
class MinifyDirective extends AbstractDirective
{
    protected $pattern = '/(?<!\\w)(\\s*)@NAME(\\s*\\(.*\\))/';

    protected $replace = <<<'EOT'
$1<?php echo app("blade-extensions.helpers")->get('minifier')->open$2; ?>
EOT;

    /**
     * MinifyDirective constructor.
     */
    public function __construct(HelperRepository $helpers)
    {
        $helpers->put('minifier', new MinifierHelper);
    }
}
