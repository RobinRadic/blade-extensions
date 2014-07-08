<?php namespace Radic\BladeExtensions\Extensions;
/**
 * Part of Radic Blade Extensions.
 *
 * @package    Radic Blade Extensions
 * @version    1.0.0
 * @author     Robin Radic
 * @license    MIT License
 * @copyright  (c) 2011-2014, Radic Technologies
 * @link       http://radic.nl
 */

use Radic\BladeExtensions\Core\BaseLoopManager;

class ForEachManager extends BaseLoopManager
{
    protected static $stack = [];

    public static function newLoop($items)
    {
        static::$stack[] = new ForEachStatement($items);
        parent::newLoop($items);
    }
}