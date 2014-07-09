<?php namespace Radic\BladeExtensions\Extensions;

use Radic\BladeExtensions\Core\LoopManager;

/**
 * Class ForEachManager
 * Part of Radic - Blade Extensions
 *
 * @package    Radic\BladeExtensions\Extensions
 * @author     Robin Radic
 * @license    MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2014, Robin Radic - Radic Technologies
 * @link       http://radic.nl
 */
class ForEachManager extends LoopManager
{
    /**
     * Creates a new ForEachStatement stack
     * @param array $items
     */
    public static function newLoop($items)
    {
        static::addLoopStack(new ForEachStatement($items));
    }
}