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

namespace Radic\BladeExtensions\Helpers\Markdown;

use cebe\markdown\GithubMarkdown;

/**
 * This is the class CebeMarkdownParser.
 *
 * @author  Robin Radic
 */
class CebeMarkdownParser implements MarkdownParserInterface
{
    protected $markdown;

    /**
     * CebeMarkdownParser constructor.
     *
     * @param \cebe\markdown\GithubMarkdown $markdown
     */
    public function __construct(GithubMarkdown $markdown)
    {
        $this->markdown = $markdown;
        $markdown->html5 = true;
    }

    /**
     * {@inheritdoc}
     */
    /**
     * parse method.
     *
     * @param string $text
     *
     * @return string
     */
    public function parse($text)
    {
        return $this->markdown->parse($text);
    }
}
