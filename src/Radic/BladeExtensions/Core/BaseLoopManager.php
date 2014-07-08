<?php namespace Radic\BladeExtensions\Core;
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


abstract class BaseLoopManager
{
    protected static $stack = [];

    public static function newLoop($items)
    {
        // static::$stack[] = new ForEachStatement($items);
        if(count(static::$stack) > 1)
        {
            // there is a parent loop, set it on current loop
            end(static::$stack)->setParentLoop(static::$stack[count(static::$stack) - 2]);
        }
    }

    public static function loop()
    {
        $current = end(static::$stack);
        $current->before();
        return $current;
    }

    public static function looped()
    {
        if(empty(static::$stack)) return;
        end(static::$stack)->after();
    }

    public static function endLoop(&$loop)
    {
        array_pop(static::$stack);
        if(count(static::$stack) > 0)
        {
            // This loop was inside another loop. We persist the loop variable and assign back the parent loop
            $loop = end(static::$stack);
        }
        else
        {
            // This loop was not inside another loop. We remove the var
            echo "l:(" . count(static::$stack) . ") ";
            $loop = null;
        }
    }
}
