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
        foreach(get_class_methods($class) as $method)
        {
            if($method == 'attach') continue;
            if(is_array($blacklist) && in_array($method, $blacklist)) continue;

            $blade->extend(function($value) use ($app, $class, $blade, $method)
            {
                return $class->$method($value, $app, $blade);
            });
        }
    }

    public function addSet($value, Application $app, Compiler $blade)
    {
        return preg_replace("/@set\('(.*?)'\,(.*)\)/", '<?php $$1 = $2; ?>', $value);
    }

    public function addDebug($value, Application $app, Compiler $blade)
    {

        $matcher = $blade->createOpenMatcher('debug');
        return preg_replace("/@debug(?:s?)\(([^()]+)*\)/", #$matcher,
            $app->config['radic/blade-extensions::debug.prepend'] . '$1' . $app->config['radic/blade-extensions::debug.append'], $value);
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
        \Radic\BladeExtensions\Extensions\ForEachManager::looped();
        continue;
        ?>$2', $value);
    }


    public function openMacro($value, Application $app, Compiler $blade)
    {
        #$matcher = "/@macro\('(\w*)', (.*)?\){(.*)?}\)/s";

        $matcher = '/@macro\([\'\"](\w*)[\'\"]\)/';
        #return preg_replace($matcher, '<?php \Radic\BladeExtensions\Extensions\MacroManager::open("$1"); ? >', $value);
        return preg_replace($matcher, '<?php \Radic\BladeExtensions\Extensions\MacroManager::open("$1", function($data){ extract($data); ?>', $value);
    }

    public function closeMacro($value, Application $app, Compiler $blade){
        $matcher = $blade->createPlainMatcher('endmacro');
       // return preg_replace($matcher, '<?php \Radic\BladeExtensions\Extensions\MacroManager::close(); ? >', $value);

        return preg_replace($matcher, '<?php });  ?>', $value);
    }


    public function addMacro($value, Application $app, Compiler $blade)
    {
        #$matcher = "/@macro\('(\w*)', (.*)?\){(.*)?}\)/s";

        $matcher = '/@macro\([\'\"](\w*)[\'\"],((?>[^()]+))*\)/';
       # return preg_replace($matcher, '<?php var_dump(\Radic\BladeExtensions\Extensions\MacroManager::render("$1", $2));  ? >', $value);
        return preg_replace($matcher, '<?php echo call_user_func(\Radic\BladeExtensions\Extensions\MacroManager::get("$1"), $2); ?>', $value);
    }




    public function openForeach($value, Application $app, Compiler $blade)
    {
        $matcher = '/@foreach(\s*)\((.[0-9a-zA-Z_\->]+(?:\([^)]*\))?)\s?(.*)\)/';
        return preg_replace($matcher,
        '$1<?php
        \Radic\BladeExtensions\Extensions\ForEachManager::newLoop($2);
        foreach($2 $3):
        $loop = \Radic\BladeExtensions\Extensions\ForEachManager::loop();
        ?>', $value);
    }

    public function closeForeach($value, Application $app, Compiler $blade)
    {
        $matcher = $blade->createPlainMatcher('endforeach');
        return preg_replace($matcher,
        '$1<?php
        \Radic\BladeExtensions\Extensions\ForEachManager::looped();
        endforeach;
        \Radic\BladeExtensions\Extensions\ForEachManager::endLoop($loop);
        ?>$2', $value);
    }
}
