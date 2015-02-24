<?php namespace Radic\BladeExtensions\Contracts;

/**
 * Directives: set, unset
 *
 * @package            Radic\BladeExtensions
 * @version            2.1.0
 * @subpackage         Contracts
 * @author             Robin Radic
 * @license            MIT License - http://radic.mit-license.org
 * @copyright          (c) 2011-2015, Robin Radic
 * @link               http://robin.radic.nl/blade-extensions
 *
 */
interface MarkdownRenderer
{
    /**
     * Renders markdown text to html
     * @param $text
     * @return mixed
     */
    public function render($text);
}
