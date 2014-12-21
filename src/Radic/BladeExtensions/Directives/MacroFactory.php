<?php namespace Radic\BladeExtensions\Extensions;


use View;

/**
 * Part of Radic - Blade Extensions.
 *
 * @package    Blade Extensions
 * @version    1.2.0
 * @author     Robin Radic
 * @license    MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2014, Robin Radic - Radic Technologies
 * @link       http://radic.nl
 *
 */
class MacroManager {
    static public $macros = [];

    static public $current;

    static function open($name, $callback)
    {
        static::$current = $name;
        static::$macros[$name] = $callback;
    }

    static function get($name = null)
    {
        if($name === null) return static::$macros;
        if(isset(static::$macros[$name])) return static::$macros[$name];
        throw new \Exception("Macro '$name' not found in BladeExtensions\\MacroManager");
    }
}
