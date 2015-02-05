<?php namespace Radic\BladeExtensions\Directives;

use Illuminate\Foundation\Application;
use Illuminate\View\Compilers\BladeCompiler as Compiler;
use Radic\BladeExtensions\Traits\BladeExtenderTrait;

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
class VariablesDirective
{

    public $blacklist = [];

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

    // regex:: http://regex101.com/r/yN1gO5/2
    public function addSet($value, Application $app, Compiler $blade)
    {
        return preg_replace('/@set\((?:\$|(?:\'))(.*?)(?:\'|),\s(.*)\)/', '<?php \$$1 = $2; ?>', $value);
    }

    public function addUnset($value, Application $app, Compiler $blade)
    {
        return preg_replace('/@unset\((?:\$|(?:\'))(.*?)(?:\'|)\)/', '<?php unset(\$$1); ?>', $value);
    }

    public function addDebug($value, Application $app, Compiler $blade)
    {
        $matcher = '/@debug(?:s?)\(([^()]+)*\)/';
        $config  = $app->config['radic/blade-extensions::debug'];
        $replace = $config['prepend'] . '$1' . $config['append'];

        return preg_replace($matcher, $replace, $value);
    }
}
