<?php
/**
 * The Parsedown markdown renderer implementation
 */
namespace Radic\BladeExtensions\Renderers;

use Radic\BladeExtensions\Contracts\MarkdownRenderer;
use \Parsedown;

/**
 * The Parsedown markdown renderer implementation
 *
 * @package        Radic\BladeExtensions
 * @subpackage     Renderers
 * @version        2.1.0
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright      2011-2015, Robin Radic
 * @link           http://robin.radic.nl/blade-extensions
 *
 */
class ParsedownRenderer implements MarkdownRenderer
{

    /**
     * The parsedown instance
     * @var \Parsedown
     */
    protected $parsedown;


    /**
     * Constructs the class
     * @param \Parsedown $parsedown
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    public function __construct(Parsedown $parsedown)
    {
        $this->parsedown = $parsedown;
    }

    /**
     * {@inheritdoc}
     * @param string $text The text
     */
    public function render($text)
    {
        #$text = preg_replace('/\s\s\n/', "<br>\n", $text);
        return $this->parsedown->text($text);
    }
}
