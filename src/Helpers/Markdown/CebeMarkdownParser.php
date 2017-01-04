<?php
/**
 * Copyright (c) 2016. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2016 (c) Robin Radic
 * @license https://radic.mit-license.org The MIT License
 */

namespace Radic\BladeExtensions\Helpers\Markdown;

use cebe\markdown\GithubMarkdown;

class CebeMarkdownParser implements MarkdownParserInterface
{

    protected $markdown;

    public function __construct(GithubMarkdown $markdown)
    {
        $this->markdown  = $markdown;
        $markdown->html5 = true;
    }

    public function parse($text)
    {
        return $this->markdown->parse($text);
    }
}
