<?php namespace Radic\BladeExtensions\Renderers;


use Ciconia\Ciconia;
use Ciconia\Extension\Gfm;
use Radic\BladeExtensions\Contracts\MarkdownRenderer;
use Illuminate\Contracts\Config\Repository as Config;

class CiconiaRenderer implements MarkdownRenderer
{

    protected $ciconia;

    protected $config;
    function __construct(\Ciconia\Ciconia $ciconia, Config $config)
    {
        $this->config = $config;
        $this->ciconia = $ciconia;
    }

    public function render($text)
    {
        $gfm         = $this->config->get('blade-extensions.markdown.gfm');
        $ciconia = new Ciconia();
        if($gfm === true)
        {
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
