<?php
/**
 * Manages the Loop instances
 */
namespace Radic\BladeExtensions\Helpers;

/**
 * Manages the Loop instances
 *
 * @package        Radic\BladeExtensions
 * @subpackage     Helpers
 * @version        2.1.0
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright      (2011-2014, Robin Radic - Radic Technologies
 * @link           http://robin.radic.nl/blade-extensions
 *
 */
class LoopFactory
{

    /**
     * The stack of Loop instances
     *
     * @var array $stack
     */
    protected static $stack = array();

    /**
     * Creates a new loop with the given array and adds it to the stack
     *
     * @param array $items The array that will be iterated
     */
    public static function newLoop($items)
    {
        static::addLoopStack(new Loop($items));
    }

    /**
     * Adds a Loop to the stack
     *
     * @param Loop $stackItem
     */
    protected static function addLoopStack(Loop $stackItem)
    {
        // Check stack for parent loop to register it with this loop
        if (count(static::$stack) > 0) {
            $stackItem->setParentLoop(last(static::$stack));
        }

        array_push(static::$stack, $stackItem);
    }

    /**
     * Returns the stack
     *
     * @return array
     */
    public static function getStack()
    {
        return static::$stack;
    }

    /**
     * Resets the stack
     */
    public static function reset()
    {
        static::$stack = array();
    }

    /**
     * To be called first inside the foreach loop. Returns the current loop
     *
     * @return Loop $current The current loop data
     */
    public static function loop()
    {
        $current = end(static::$stack);
        $current->before();

        return $current;
    }

    /**
     * To be called before the end of the loop
     */
    public static function looped()
    {
        if (! empty(static::$stack)) {
            end(static::$stack)->after();
        }
    }

    /**
     * Should be called after the loop has finished
     *
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
