<?php
namespace Radic\BladeExtensions\Helpers\Markdown;

use cebe\markdown\GithubMarkdown;

class CebeMarkdownParser implements MarkdownParserInterface
{

    protected $markdown;

    public function __construct(GithubMarkdown $markdown)
    {
        $this->markdown  = $markdown;
        $markdown->html5 = true;
    }

    public function parse($text)
    {
        return $this->markdown->parse($text);
    }
}
