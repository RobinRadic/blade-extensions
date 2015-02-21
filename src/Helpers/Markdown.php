<?php namespace Radic\BladeExtensions\Helpers;

use Stringy\Stringy;

/**
 * Markdown transformer
 *
 * @package            Radic\BladeExtensions
 * @version            2.1.0
 * @subpackage         Directives
 * @author             Robin Radic
 * @license            MIT License - http://radic.mit-license.org
 * @copyright          (c) 2011-2015, Robin Radic
 * @link               http://robin.radic.nl/blade-extensions
 *
 */
class Markdown
{
    protected static function transform($text)
    {
        $firstLine = explode("\n", $text, 1);
        $firstLine = Stringy::create($firstLine[0])->toSpaces();
        preg_match('/([\s]*).*/', $firstLine, $firstLineSpacesMatches);

        if(isset($firstLineSpacesMatches[1])){
            $spaceMatcher = "";
            for($i = 0; $i < strlen($firstLineSpacesMatches[1]); $i++){
                $spaceMatcher .= "\s";
            }
            $spaceMatcher = '/^' . $spaceMatcher . '(.*)/m';
            $newText = preg_replace($spaceMatcher, '$1', $text);
            return $newText;
        }

        return $text;
        //$parsedown->text()
    }

    public static function parse($text)
    {
        $text = static::transform($text);
        //$pd = new \Parsedown();
        $newText = app()->make('markdown')->render($text);
        //$newText = $pd->text($text);
        return $newText;
    }
}
