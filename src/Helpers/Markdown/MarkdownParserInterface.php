<?php
/**
 * Part of the Radic PHP packages.
 *
 * License and copyright information bundled with this package in the LICENSE file
 */

namespace Radic\BladeExtensions\Helpers\Markdown;


interface MarkdownParserInterface
{
    /**
     * Parses Markdown into HTML
     *
     * @param string $text The Markdown text
     *
     * @return string
     */
    public function parse($text);
}
