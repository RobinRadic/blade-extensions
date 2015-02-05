<?php namespace Radic\BladeExtensions\Directives;

use Illuminate\Foundation\Application;
use Illuminate\View\Compilers\BladeCompiler as Compiler;
use Radic\BladeExtensions\Traits\BladeExtenderTrait;

/**
 * Variable manipulation directives like `set`, `unset`, `debug`
 *
 * @package        Radic\BladeExtensions
 * @subpackage     Directives
 * @version        1.3.0
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2014, Robin Radic - Radic Technologies
 * @link           http://robin.radic.nl/blade-extensions
 *
 */
class VariablesDirective
{

    use BladeExtenderTrait;


    /**
     * Adds `set` directive
     *
     * @param             $value
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function addSet($value, Application $app, Compiler $blade)
    {
        // regex:: http://regex101.com/r/yN1gO5/2
        return preg_replace('/@set\((?:\$|(?:\'))(.*?)(?:\'|),\s(.*)\)/', '<?php \$$1 = $2; ?>', $value);
    }

    /**
     * Adds `unset` directive
     *
     * @param             $value
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function addUnset($value, Application $app, Compiler $blade)
    {
        return preg_replace('/@unset\((?:\$|(?:\'))(.*?)(?:\'|)\)/', '<?php unset(\$$1); ?>', $value);
    }

    /**
     * Adds `debug` directive
     *
     * @param             $value
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function addDebug($value, Application $app, Compiler $blade)
    {
        $matcher = '/@debug(?:s?)\(([^()]+)*\)/';
        $config  = $app->config['radic/blade-extensions::debug'];
        $replace = $config['prepend'] . '$1' . $config['append'];

        return preg_replace($matcher, $replace, $value);
    }
}
