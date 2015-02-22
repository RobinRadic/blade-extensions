<?php namespace Radic\BladeExtensions\Traits;

use Illuminate\Foundation\Application;

/**
 * Adds an static function `attach` that if called, will instanciate and execute all functions as blade extends
 *
 * @package            Radic\BladeExtensions
 * @version            2.1.0
 * @author             Robin Radic
 * @license            MIT License - http://radic.mit-license.org
 * @copyright      (c) 2011-2015, Robin Radic
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

    public $directives;

    /**
     * Instanciate and execute all functions as blade extends
     *
     * @param Application $app        The current application
     */
    public static function attach(Application $app)
    {
        /** @var \Illuminate\View\Compilers\BladeCompiler $blade */
        $blade = $app['view']->getEngineResolver()->resolve('blade')->getCompiler();

        $class      = new static;
        $directives = isset($class->directives) ? $class->directives : $app['config']->get('blade-extensions.directives');
        $blacklist  = isset($class->blacklist) ? $class->blacklist : $app['config']->get('blade-extensions.blacklist');

        foreach (get_class_methods($class) as $method)
        {
            if ($method == 'attach' or (is_array($blacklist) && in_array($method, $blacklist)))
            {
                continue;
            }

            $directive = isset($directives[$method]) ? $directives[$method] : false;

            $blade->extend(
                function ($value) use ($app, $class, $blade, $method, $directive)
                {
                    return $class->$method($value, $directive, $app, $blade);
                }
            );
        }
    }
}
