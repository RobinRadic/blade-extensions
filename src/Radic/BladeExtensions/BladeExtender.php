<?php namespace Radic\BladeExtensions;

use Illuminate\Foundation\Application;
use Illuminate\View\Compilers\BladeCompiler as Compiler;

/**
 * Part of Radic - Blade Extensions.
 *
 * @package    Blade Extensions
 * @version    1.0.0
 * @author     Robin Radic
 * @license    MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2014, Robin Radic - Radic Technologies
 * @link       http://radic.nl
 *
 *
 * @makeview\(((?>[^()]+))*\)
 */
// http://packalyst.com/packages/package/crhayes/blade-partials
class BladeExtender
{

    public static function attach(Application $app)
    {
        $blade = $app['view']->getEngineResolver()->resolve('blade')->getCompiler();
        $class = new static;
        $blacklist = $app->config['radic/blade-extensions::blacklist'];
        foreach (get_class_methods($class) as $method) {
            if ($method == 'attach') continue;
            if (is_array($blacklist) && in_array($method, $blacklist)) continue;

            $blade->extend(function ($value) use ($app, $class, $blade, $method) {
                return $class->$method($value, $app, $blade);
            });
        }
    }


    // regex:: http://regex101.com/r/yN1gO5/2
    public function addSet($value, Application $app, Compiler $blade)
    {
        return preg_replace('/@set\((?:\$|(?:\'))(.*?)(?:\'|),\s(.*)\)/', '<?php \$$1 = $2; ?>', $value);
    }

    public function addUnset($value, Application $app, Compiler $blade)
    {

        return preg_replace('/@unset\((.*)\)/', '<?php unset($1); ?>', $value);
    }

    public function addDebug($value, Application $app, Compiler $blade)
    {

        $matcher = $blade->createOpenMatcher('debug');
        return preg_replace("/@debug(?:s?)\(([^()]+)*\)/", #$matcher,
            $app->config['radic/blade-extensions::debug.prepend'] . '$1' . $app->config['radic/blade-extensions::debug.append'], $value);

    }


    # MACRO

    public function openMacro($value, Application $app, Compiler $blade)
    {
        //$matcher = '/@macro\([\'\"](\w*)[\'\"]\)/';
        $matcher = '/@macro\([\'"]([\w\d]*)[\'"],(.*)\)/';
        return preg_replace($matcher, '<?php HTML::macro("$1", function($2){ ', $value);
    }

    public function closeMacro($value, Application $app, Compiler $blade)
    {
        $matcher = $blade->createPlainMatcher('endmacro');
        return preg_replace($matcher, '  });  ?>', $value);
    }

    public function DoMacro($value, Application $app, Compiler $blade)
    {
        $matcher = '/@domacro\([\'"]([\w\d]*)[\'"],(.*)\)/';
        return preg_replace($matcher, '<?php echo HTML::$1($2); ?>', $value);
    }


    # LOOPS
    // regex test: http://regex101.com/r/qH9eO7/2
    public function openForeach($value, Application $app, Compiler $blade)
    {
        $matcher = '/@foreach\((.*)(?:\sas)(.*)\)/';
        return preg_replace($matcher,
            '<?php
        \Radic\BladeExtensions\Directives\ForeachLoopFactory::newLoop($1);
        foreach($1 as $2):
        $loop = \Radic\BladeExtensions\Directives\ForeachLoopFactory::loop();
        ?>', $value);
    }

    public function closeForeach($value, Application $app, Compiler $blade)
    {
        $matcher = $blade->createPlainMatcher('endforeach');
        return preg_replace($matcher,
            '$1<?php
        \Radic\BladeExtensions\Directives\ForeachLoopFactory::looped();
        endforeach;
        \Radic\BladeExtensions\Directives\ForeachLoopFactory::endLoop($loop);
        ?>$2', $value);
    }

    public function addBreak($value, Application $app, Compiler $blade)
    {
        $matcher = $blade->createPlainMatcher('break');
        return preg_replace($matcher,
            '$1<?php
        break;
        ?>$2', $value);
    }

    public function addContinue($value, Application $app, Compiler $blade)
    {
        $matcher = $blade->createPlainMatcher('continue');
        return preg_replace($matcher,
            '$1<?php
        \Radic\BladeExtensions\Directives\ForeachLoopFactory::looped();
        continue;
        ?>$2', $value);
    }


    # PARTIALS

    public function addPartial($value, Application $app, Compiler $blade)
    {
        $matcher = $blade->createOpenMatcher('partial');
        return preg_replace($matcher,
            '$1<?php $__env->renderPartial$2, get_defined_vars(), function($file, $vars) use ($__env) {
					$vars = array_except($vars, array(\'__data\', \'__path\'));
					extract($vars); ?>'
            , $value);
    }

    public function endPartial($value, Application $app, Compiler $blade)
    {
        $pattern = $blade->createPlainMatcher('endpartial');
        return preg_replace($pattern, '$1<?php echo $__env->make($file, $vars)->render(); }); ?>$2', $value);
    }

    public function openBlock($value, Application $app, Compiler $blade)
    {
        $pattern = $blade->createMatcher('block');
        return preg_replace($pattern, '$1<?php $__env->startBlock$2; ?>', $value);
    }

    public function endBlock($value, Application $app, Compiler $blade)
    {
        $pattern = $blade->createPlainMatcher('endblock');
        return preg_replace($pattern, '$1<?php $__env->stopBlock(); ?>$2', $value);
    }

    public function addRender($value, Application $app, Compiler $blade)
    {
        $pattern = $blade->createMatcher('render');
        return preg_replace($pattern, '$1<?php echo $__env->renderBlock$2; ?>', $value);
    }


}
