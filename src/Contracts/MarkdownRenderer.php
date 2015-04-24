<?php
/**
 * Directives: set, unset
 */
namespace Radic\BladeExtensions\Contracts;

/**
 * Directives: set, unset
 *
 * @package            Radic\BladeExtensions
 * @subpackage         Contracts
 * @version            2.1.0
 * @author             Robin Radic
 * @license            MIT License - http://radic.mit-license.org
 * @copyright          2011-2015, Robin Radic
 * @link               http://robin.radic.nl/blade-extensions
 *
 */
interface MarkdownRenderer
{
    /**
     * Renders markdown text to html
     * @param string $text The text
     * @return mixed
     */
    function render($text);
}
