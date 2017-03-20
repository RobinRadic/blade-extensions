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

/**
 * This is the class ForeachDirective.
 *
 * @author  Robin Radic
 */
class ForeachDirective extends AbstractDirective
{
    protected $pattern = '/(?<!\w)(\s*)@foreach(?:\s*)\(([\w\W]*?)(?:\sas)(.*)\)/';

    protected $replace = <<<'EOT'
$1<?php
app('blade-extensions.helpers')->get('loop')->newLoop($2);
foreach(app('blade-extensions.helpers')->get('loop')->getLastStack()->getItems() as $3):
    $loop = app('blade-extensions.helpers')->get('loop')->loop();
?>
EOT;

    /**
     * DumpDirective constructor.
     */
    public function __construct(HelperRepository $helpers)
    {
        $helpers->put('loop', new \Radic\BladeExtensions\Helpers\Loop\LoopHelper());
    }
}
