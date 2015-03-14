<?php
/**
 * The Ciconia markdown renderer implementation
 */
namespace Radic\BladeExtensions\Renderers;

use Ciconia\Ciconia;
use Ciconia\Extension\Gfm;
use Radic\BladeExtensions\Contracts\MarkdownRenderer;
use Illuminate\Contracts\Config\Repository as Config;

/**
 * The Ciconia markdown renderer implementation
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
class CiconiaRenderer implements MarkdownRenderer
{

    /**
     * The Ciconia implementation
     * @var \Ciconia\Ciconia
     */
    protected $ciconia;


    /**
     * In
     * @param \Ciconia\Ciconia $ciconia
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    function __construct(Ciconia $ciconia)
    {
        $this->ciconia = $ciconia;
    }

    /**
     * {@inheritdoc}
     * @param string $text The text
     */
    public function render($text)
    {
        $this->ciconia->addExtension(new Gfm\FencedCodeBlockExtension());
        $this->ciconia->addExtension(new Gfm\TaskListExtension());
        $this->ciconia->addExtension(new Gfm\InlineStyleExtension());
        $this->ciconia->addExtension(new Gfm\WhiteSpaceExtension());
        $this->ciconia->addExtension(new Gfm\TableExtension());
        $this->ciconia->addExtension(new Gfm\UrlAutoLinkExtension());

        return $this->ciconia->render($text);
    }
}
