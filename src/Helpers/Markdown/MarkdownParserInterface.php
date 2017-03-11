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

/**
 * Interface MarkdownParserInterface.
 *
 * @author  Robin Radic
 */
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
