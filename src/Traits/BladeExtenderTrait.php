<?php
/**
 * Adds an static function `attach` that if called, will instanciate and execute all functions as blade extends
 */
namespace Radic\BladeExtensions\Traits;

use Config;
use Illuminate\Foundation\Application;
use View;

/**
 * Adds an static function `attach` that if called, will instanciate and execute all functions as blade extends
 *
 * @package            Radic\BladeExtensions
 * @version            2.1.0
 * @author             Robin Radic
 * @license            MIT License - http://radic.mit-license.org
 * @copyright       2011-2015, Robin Radic
 * @link               http://robin.radic.nl/blade-extensions
 *
 */
trait BladeExtenderTrait
{

    /**
     * An array of methods that should be excluded by attach
     *
     * @var array
     */
    public $blacklist;

    /**
     * An array of methodName => directiveReplacement
     * @var array
     */
    public $directives;

    /**
     * Instanciate and execute all functions as blade extends
     *
     * @param Application $app The current application
     */
    public static function attach(Application $app)
    {
        /** @var \Illuminate\View\Compilers\BladeCompiler $blade */
        $blade = View::getEngineResolver()->resolve('blade')->getCompiler();

        $class      = new static;
        $directives = isset($class->directives) ? $class->directives : Config::get('blade_extensions.directives');
        $blacklist  = isset($class->blacklist) ? $class->blacklist : Config::get('blade_extensions.blacklist');

        foreach (get_class_methods($class) as $method) {
            if (in_array($method, ['attach', 'createMatcher', 'createOpenMatcher', 'createPlainMatcher']) or (is_array($blacklist) && in_array($method, $blacklist))) {
                continue;
            }

            $directive = isset($directives[$method]) ? $directives[$method] : false;

            $blade->extend(function ($value) use ($app, $class, $blade, $method, $directive) {
            
                return $class->$method($value, $directive, $app, $blade);
            });
        }
    }


    /**
     * Get the regular expression for a generic Blade function.
     *
     * @param  string  $function
     * @return string
     */
    public function createMatcher($function)
    {
        return '/(?<!\w)(\s*)@'.$function.'(\s*\(.*\))/';
    }

    /**
     * Get the regular expression for a generic Blade function.
     *
     * @param  string  $function
     * @return string
     */
    public function createOpenMatcher($function)
    {
        return '/(?<!\w)(\s*)@'.$function.'(\s*\(.*)\)/';
    }

    /**
     * Create a plain Blade matcher.
     *
     * @param  string  $function
     * @return string
     */
    public function createPlainMatcher($function)
    {
        return '/(?<!\w)(\s*)@'.$function.'(\s*)/';
    }
}
