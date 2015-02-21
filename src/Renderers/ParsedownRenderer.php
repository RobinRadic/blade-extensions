<?php namespace Radic\BladeExtensions\Renderers;


use Radic\BladeExtensions\Contracts\MarkdownRenderer;
use Illuminate\Contracts\Config\Repository as Config;

class ParsedownRenderer implements  MarkdownRenderer
{

    protected $parsedown;

    protected $config;

    function __construct(\Parsedown $parsedown, Config $config)
    {
        $this->config = $config;
        $this->parsedown = $parsedown;
    }

    public function render($text)
    {
        return $this->parsedown->text($text);
    }
}
