<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright 2017 Robin Radic
 * @license https://radic.mit-license.org MIT License
 * @version 7.0.0
 */
namespace Radic\BladeExtensions\Helpers\Markdown;

use Laradic\Support\Str;
use Illuminate\Contracts\Container\Container;

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
    protected $app;

    protected $renderer;

    /**
     * Markdown constructor.
     *
     * @param \Illuminate\Contracts\Container\Container $app
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
        $class = $app['config']->get('blade-extensions.markdown.renderer');
        //$this->renderer  = $this->container->make($class);
    }

    /**
     * Removes indentation.
     *
     * @param string $text The markdown text
     *
     * @return mixed
     */
    protected function transform($text)
    {
        $firstLine = explode("\n", $text, 1);
        $firstLine = Str::toSpaces($firstLine[0], 4);
        preg_match('/([\s]*).*/', $firstLine, $firstLineSpacesMatches);

        if (isset($firstLineSpacesMatches[1])) {
            $spaceMatcher = '';
            for ($i = 0; $i < strlen($firstLineSpacesMatches[1]); $i++) {
                $spaceMatcher .= "\s";
            }
            $spaceMatcher = '/^'.$spaceMatcher.'(.*)/m';
            $newText = preg_replace($spaceMatcher, '$1', $text);

            return $newText;
        }

        return $text;
    }

    /**
     * Parses markdown text into html.
     *
     * @param string $text the markdown text
     *
     * @return string $newText html
     */
    public function parse($text)
    {
        $text = $this->transform($text);
        $newText = $this->renderer->render($text);

        return $newText;
    }
}
