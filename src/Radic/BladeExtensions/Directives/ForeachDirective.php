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
class ForeachDirective
{
    use BladeExtenderTrait;

    // regex test: http://regex101.com/r/qH9eO7/2
    public function openForeach($value, Application $app, Compiler $blade)
    {
        $matcher = '/@foreach\((.*)(?:\sas)(.*)\)/';
        $replace = '<?php
        \Radic\BladeExtensions\Helpers\Loop::newLoop($1);
        foreach($1 as $2):
        $loop = \Radic\BladeExtensions\Helpers\Loop::loop();
        ?>';

        return preg_replace($matcher, $replace, $value);
    }

    public function closeForeach($value, Application $app, Compiler $blade)
    {
        $matcher = $blade->createPlainMatcher('endforeach');
        $replace = '$1<?php
        \Radic\BladeExtensions\Helpers\Loop::looped();
        endforeach;
        \Radic\BladeExtensions\Helpers\Loop::endLoop($loop);
        ?>$2';

        return preg_replace($matcher, $replace, $value);
    }

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

    public function addContinue($value, Application $app, Compiler $blade)
    {
        $matcher = $blade->createPlainMatcher('continue');

        return preg_replace(
            $matcher,
            '$1<?php
        \Radic\BladeExtensions\Helpers\Loop::looped();
        continue;
        ?>$2',
            $value
        );
    }
}
