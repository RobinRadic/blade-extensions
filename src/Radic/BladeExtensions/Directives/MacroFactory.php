<?php
/**
 * Created by PhpStorm.
 * User: radic
 * Date: 9/16/14
 * Time: 1:07 PM
 */

namespace Radic\BladeExtensions\Extensions;


use View;

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