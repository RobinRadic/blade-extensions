<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2017 (c) Robin Radic
 * @license https://radic.mit-license.org The MIT License
 */

namespace Radic\BladeExtensions\Helpers\Markdown;

interface MarkdownParserInterface
{
    /**
     * Parses Markdown into HTML.
     *
     * @param string $text The Markdown text
     *
     * @return string
     */
    public function parse($text);
}
