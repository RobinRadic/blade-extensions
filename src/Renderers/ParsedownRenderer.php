<?php namespace Radic\BladeExtensions\Renderers;


use Radic\BladeExtensions\Contracts\MarkdownRenderer;
use Illuminate\Contracts\Config\Repository as Config;
use Parsedown;
/**
 * The Parsedown markdown renderer implementation
 *
 * @package        Radic\BladeExtensions
 * @version        2.1.0
 * @subpackage     Renderers
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright      (c) 2011-2015, Robin Radic
 * @link           http://robin.radic.nl/blade-extensions
 *
 */
class ParsedownRenderer implements  MarkdownRenderer
{

    /**
     * @var \Parsedown
     */
    protected $parsedown;

    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * @param \Parsedown $parsedown
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    function __construct(\Parsedown $parsedown, Config $config)
    {
        $this->config = $config;
        $this->parsedown = $parsedown;
    }

    /** @inheritdoc */
    public function render($text)
    {
        return $this->parsedown->text($text);
    }
}
