<?php namespace Radic\BladeExtensions\Directives;

use Radic\BladeExtensions\Core\LoopFactory;

/**
 * Class ForeachLoopFactory
 * Part of Radic - Blade Extensions
 *
 * @package    Radic\BladeExtensions\Directives
 * @author     Robin Radic
 * @license    MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2014, Robin Radic - Radic Technologies
 * @link       http://radic.nl
 */
class ForeachLoopFactory extends LoopFactory
{
    /**
     * Creates a new ForEachStatement stack
     * @param array $items
     */
    public static function newLoop($items)
    {
        static::addLoopStack(new ForeachLoopItem($items));
    }
}