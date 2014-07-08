<?php namespace Radic\BladeExtensions;
/**
 * Part of Radic Blade Extensions.
 *
 * @package    Radic Blade Extensions
 * @version    1.0.0
 * @author     Robin Radic
 * @license    MIT License
 * @copyright  (c) 2011-2014, Radic Technologies
 * @link       http://radic.nl
 */

use Illuminate\Foundation\Application;
use Illuminate\View\Compilers\BladeCompiler as Compiler;


class BladeExtender
{

    public static function attach(Application $app)
    {
        $blade = $app['view']->getEngineResolver()->resolve('blade')->getCompiler();
        $class = new static;
        foreach(get_class_methods($class) as $method)
        {

            if($method == 'attach') continue;

            $blade->extend(function($value) use ($app, $class, $blade, $method)
            {
                return $class->$method($value, $app, $blade);
            });
        }

    }

    public function addBreak($value, Application $app, Compiler $blade)
    {
        $matcher = $blade->createPlainMatcher('break');
        return preg_replace($matcher, '$1<?php break; ?>$2', $value);
    }

    public function addContinue($value, Application $app, Compiler $blade)
    {
        $matcher = $blade->createPlainMatcher('continue');
        return preg_replace($matcher, '$1<?php continue; ?>$2', $value);
    }

    public function openForeach($value, Application $app, Compiler $blade)
    {
        #$op = '/@'.$function.'(\s*\(.*)\)/';
        $matcher = '/@foreach(\s?)\(\$(.[0-9a-zA-Z_]+)(\s?)(.*)\)/';
        //$matcher = $blade->createOpenMatcher('foreach');
        return preg_replace($matcher, '$1<?php
         \Radic\BladeExtensions\Extensions\ForEachManager::newLoop($$2);
        foreach($$2 $4):
        $loop = \Radic\BladeExtensions\Extensions\ForEachManager::loop(); ?>', $value);
    }
    public function closeForeach($value, Application $app, Compiler $blade)
    {
        $matcher = $blade->createPlainMatcher('endforeach');
        return preg_replace($matcher, '$1<?php
            unset($loop);
            \Radic\BladeExtensions\Extensions\ForEachManager::looped();
            endforeach;
            \Radic\BladeExtensions\Extensions\ForEachManager::endLoop();
        ?>$2', $value);
    }
}