<?php namespace Radic\BladeExtensions\Directives;

use Illuminate\Foundation\Application;
use Illuminate\View\Compilers\BladeCompiler as Compiler;
use Radic\BladeExtensions\Traits\BladeExtenderTrait;

/**
 * Partials directives
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
class PartialDirective
{
    use BladeExtenderTrait;

    /**
     * @param             $value
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function addPartial($value, Application $app, Compiler $blade)
    {
        $matcher = $blade->createOpenMatcher('partial');

        return preg_replace(
            $matcher,
            '$1<?php \Radic\BladeExtensions\Helpers\Partial::renderPartial$2,' .
            'get_defined_vars(), function($file, $vars) use ($__env) {
					$vars = array_except($vars, array(\'__data\', \'__path\'));
					extract($vars); ?>',
            $value
        );
    }

    /**
     * @param             $value
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function endPartial($value, Application $app, Compiler $blade)
    {
        $pattern = $blade->createPlainMatcher('endpartial');

        return preg_replace($pattern, '$1<?php echo $__env->make($file, $vars)->render(); }); ?>$2', $value);
    }

    /**
     * @param             $value
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function openBlock($value, Application $app, Compiler $blade)
    {
        $pattern = $blade->createMatcher('block');

        return preg_replace($pattern, '$1<?php \Radic\BladeExtensions\Helpers\Partial::startBlock$2; ?>', $value);
    }

    /**
     * @param             $value
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function endBlock($value, Application $app, Compiler $blade)
    {
        $pattern = $blade->createPlainMatcher('endblock');

        return preg_replace($pattern, '$1<?php \Radic\BladeExtensions\Helpers\Partial::stopBlock(); ?>$2', $value);
    }

    /**
     * @param             $value
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function addRender($value, Application $app, Compiler $blade)
    {
        $pattern = $blade->createMatcher('render');

        return preg_replace($pattern, '$1<?php echo \Radic\BladeExtensions\Helpers\Partial::renderBlock$2; ?>', $value);
    }
}
