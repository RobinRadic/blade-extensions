<?php namespace Radic\BladeExtensions\Helpers;

/**
 * Part of Radic - Blade Extensions.
 *
 * @package        Blade Extensions
 * @version        1.2.0
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2014, Robin Radic - Radic Technologies
 * @link           http://radic.nl
 *
 */

class Loop
{

    /**
     * @var array $stack
     */
    protected static $stack = array();

    public static function newLoop($items)
    {
        static::addLoopStack(new LoopItem($items));
    }

    protected static function addLoopStack(LoopItem $stackItem)
    {
        // Check stack for parent loop to register it with this loop
        if (count(static::$stack) > 0) {
            $stackItem->setParentLoop(last(static::$stack));
        }

        array_push(static::$stack, $stackItem);
    }

    public static function getStack()
    {
        return static::$stack;
    }

    public static function reset()
    {
        static::$stack = array();
    }

    /**
     * @return mixed
     */
    public static function loop()
    {
        $current = end(static::$stack);
        $current->before();

        return $current;
    }

    /**
     *
     */
    public static function looped()
    {
        if (empty(static::$stack)) {
            return;
        }
        end(static::$stack)->after();
    }

    /**
     * @param $loop
     */
    public static function endLoop(&$loop)
    {
        array_pop(static::$stack);
        if (count(static::$stack) > 0) {
            // This loop was inside another loop. We persist the loop variable and assign back the parent loop
            $loop = end(static::$stack);
        } else {
            // This loop was not inside another loop. We remove the var
            //echo "l:(" . count(static::$stack) . ") ";
            $loop = null;
        }
    }
}
