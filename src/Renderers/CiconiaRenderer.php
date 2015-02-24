<?php namespace Radic\BladeExtensions\Renderers;

use Ciconia\Ciconia;
use Ciconia\Extension\Gfm;
use Radic\BladeExtensions\Contracts\MarkdownRenderer;
use Illuminate\Contracts\Config\Repository as Config;

/**
 * The Ciconia markdown renderer implementation
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
class CiconiaRenderer implements MarkdownRenderer
{

    /**
     * @var \Ciconia\Ciconia
     */
    protected $ciconia;

    /**
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;

    /**
     * @param \Ciconia\Ciconia $ciconia
     * @param \Illuminate\Contracts\Config\Repository $config
     */
    function __construct(\Ciconia\Ciconia $ciconia, Config $config)
    {
        $this->config = $config;
        $this->ciconia = $ciconia;
    }

    /** @inheritdoc */
    public function render($text)
    {
        $gfm         = $this->config->get('blade_extensions.markdown.gfm');
        $ciconia = new Ciconia();
        if ($gfm === true) {
            $ciconia->addExtension(new Gfm\FencedCodeBlockExtension());
            $ciconia->addExtension(new Gfm\TaskListExtension());
            $ciconia->addExtension(new Gfm\InlineStyleExtension());
            $ciconia->addExtension(new Gfm\WhiteSpaceExtension());
            $ciconia->addExtension(new Gfm\TableExtension());
            $ciconia->addExtension(new Gfm\UrlAutoLinkExtension());
        }
        return $this->ciconia->render($text);
    }
}
