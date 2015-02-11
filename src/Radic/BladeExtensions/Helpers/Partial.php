<?php namespace Radic\BladeExtensions\Helpers;

/**
 * Manages the partial directive blocks
 *
 * @package        Radic\BladeExtensions
 * @subpackage     Helpers
 * @version        2.0.0
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2014, Robin Radic - Radic Technologies
 * @link           http://robin.radic.nl/blade-extensions
 *
 */
class Partial
{

    /**
     * Storage for our blocks.
     *
     * @var array
     */
    static protected $blocks = array();

    /**
     * Render a partial by echoing its contents.
     * The variables defined outside the scope of this block
     * (i.e. within our template) are passed in so we can use them.
     *
     * @param  string   $file
     * @param  array    $vars
     * @param  \Closure $callback
     * @return void
     */
    public static function renderPartial($file, $vars, \Closure $callback)
    {
        $callback($file, $vars);
        static::flushBlocks();
    }

    /**
     * Start injecting content into a block.
     *
     * @param  string $block
     * @param  string $content
     * @return void
     */
    public static function startBlock($block, $content = '')
    {
        if ($content === '') {
            if (ob_start()) {
                static::$blocks[] = $block;
            }
        } else {
            static::$blocks[$block] = $content;
        }
    }

    /**
     * Stop injecting content into a block.
     *
     * @return void
     */
    public static function stopBlock()
    {
        $last                  = array_pop(static::$blocks);
        static::$blocks[$last] = ob_get_clean();
    }

    /**
     * Get the string contents of a block.
     *
     * @param  string $block
     * @param  string $default
     * @return string
     */
    public static function renderBlock($block, $default = '')
    {
        return isset(static::$blocks[$block]) ? static::$blocks[$block] : $default;
    }

    /**
     * Get the entire array of blocks.
     *
     * @return array
     */
    public static function getBlocks()
    {
        return static::$blocks;
    }

    /**
     * Flush all the block contents.
     *
     * @return void
     */
    public static function flushBlocks()
    {
        static::$blocks = array();
    }
}
