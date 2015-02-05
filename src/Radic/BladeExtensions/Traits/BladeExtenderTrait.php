<?php namespace Radic\BladeExtensions\Traits;

use Illuminate\Foundation\Application;

/**
 * Adds an static function `attach` that if called, will instanciate and execute all functions as blade extends
 *
 * @package        Radic\BladeExtensions
 * @subpackage     Traits
 * @version        1.3.0
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2014, Robin Radic - Radic Technologies
 * @link           http://robin.radic.nl/blade-extensions
 *
 */
trait BladeExtenderTrait
{

    /**
     * An array of methods that should be excluded by attach
     *
     * @var array
     */
    public $blacklist = [];

    /**
     * Instanciate and execute all functions as blade extends
     *
     * @param Application $app
     */
    public static function attach(Application $app)
    {
        $blade = $app['view']->getEngineResolver()->resolve('blade')->getCompiler();
        $class = new static;
        foreach (get_class_methods($class) as $method) {
            if ($method == 'attach') {
                continue;
            }
            if (is_array($class->blacklist) && in_array($method, $class->blacklist)) {
                continue;
            }

            $blade->extend(
                function ($value) use ($app, $class, $blade, $method) {
                    return $class->$method($value, $app, $blade);
                }
            );
        }
    }
}
