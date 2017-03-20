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
use Radic\BladeExtensions\Helpers\Markdown\MarkdownHelper;
use Radic\BladeExtensions\Helpers\Markdown\MarkdownParserInterface;

/**
 * This is the class MarkdownDirective.
 *
 * @author  Robin Radic
 */
class MarkdownDirective extends AbstractDirective
{
    protected $pattern = '/(?<!\w)(\s*)@NAME(?!\()(\s*)/';

    protected $replace = <<<'EOT'
$1<?php echo app("blade-extensions.helpers")->get('markdown')->parse(<<<'EOT'$2
EOT;

    /**
     * MarkdownDirective constructor.
     *
     * @param \Radic\BladeExtensions\Contracts\HelperRepository               $helpers
     * @param \Radic\BladeExtensions\Helpers\Markdown\MarkdownParserInterface $markdown
     */
    public function __construct(HelperRepository $helpers, MarkdownParserInterface $markdown)
    {
        $helpers->put('markdown', $helper = new MarkdownHelper());
        $helper->setParser($markdown);
    }
}
