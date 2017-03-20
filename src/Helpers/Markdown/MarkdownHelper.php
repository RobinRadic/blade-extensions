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
 * Markdown transformer Helpers.
 *
 * @version                 2.1.0
 * @author                  Robin Radic
 * @license                 MIT License - http://radic.mit-license.org
 * @copyright               2011-2015, Robin Radic
 * @link                    http://robin.radic.nl/blade-extensions
 */
class MarkdownHelper
{
    /** @var MarkdownParserInterface */
    protected $parser;

    /**
     * Parses markdown text into html.
     *
     * @param string $text the markdown text
     *
     * @return string $newText html
     */
    public function parse($text)
    {
        return $this->parser->parse($text);
    }

    /**
     * @return \Radic\BladeExtensions\Helpers\Markdown\MarkdownParserInterface
     */
    public function getParser()
    {
        return $this->parser;
    }

    /**
     * Set the parser value.
     *
     * @param \Radic\BladeExtensions\Helpers\Markdown\MarkdownParserInterface $parser
     *
     * @return MarkdownHelper
     */
    public function setParser(MarkdownParserInterface $parser)
    {
        $this->parser = $parser;

        return $this;
    }
}
