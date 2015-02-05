<?php namespace Radic\BladeExtensions\Directives;

use Illuminate\Foundation\Application;
use Illuminate\View\Compilers\BladeCompiler as Compiler;
use Radic\BladeExtensions\Traits\BladeExtenderTrait;

/**
 * Foreach directives
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
class ForeachDirective
{
    use BladeExtenderTrait;

    /**
     * Starts `foreach` directive
     *
     * @param             $value
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function openForeach($value, Application $app, Compiler $blade)
    {
        $matcher = '/@foreach\((.*)(?:\sas)(.*)\)/';
        $replace = '<?php
        \Radic\BladeExtensions\Helpers\LoopFactory::newLoop($1);
        foreach($1 as $2):
        $loop = \Radic\BladeExtensions\Helpers\LoopFactory::loop();

        ?>';

        return preg_replace($matcher, $replace, $value);
    }

    /**
     * Ends `foreach` directive
     *
     * @param             $value
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function closeForeach($value, Application $app, Compiler $blade)
    {
        $matcher = $blade->createPlainMatcher('endforeach');
        $replace = '$1<?php
        \Radic\BladeExtensions\Helpers\LoopFactory::looped();
        endforeach;
        \Radic\BladeExtensions\Helpers\LoopFactory::endLoop($loop);
        ?>$2';

        return preg_replace($matcher, $replace, $value);
    }

    /**
     * Adds `break` directive
     *
     * @param             $value
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function addBreak($value, Application $app, Compiler $blade)
    {
        $matcher = $blade->createPlainMatcher('break');

        return preg_replace(
            $matcher,
            '$1<?php
        break;
        ?>$2',
            $value
        );
    }

    /**
     * Adds `continue` directive
     *
     * @param             $value
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function addContinue($value, Application $app, Compiler $blade)
    {
        $matcher = $blade->createPlainMatcher('continue');

        return preg_replace(
            $matcher,
            '$1<?php
        \Radic\BladeExtensions\Helpers\LoopFactory::looped();
        continue;
        ?>$2',
            $value
        );
    }
}
