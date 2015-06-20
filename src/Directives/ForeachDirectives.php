<?php
/**
 * Directives: foreach, endforeach, break, continue
 */
namespace Radic\BladeExtensions\Directives;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\View\Compilers\BladeCompiler as Compiler;
use Radic\BladeExtensions\Traits\BladeExtenderTrait;

/**
 * Directives: foreach, endforeach, break, continue
 *
 * @package            Radic\BladeExtensions
 * @subpackage         Directives
 * @version            2.1.0
 * @author             Robin Radic
 * @license            MIT License - http://radic.mit-license.org
 * @copyright          2011-2015, Robin Radic
 * @link               http://robin.radic.nl/blade-extensions
 *
 */
class ForeachDirectives
{
    use BladeExtenderTrait;

    /**
     * Starts `foreach` directive
     *
     * @param             $value
     * @param             $directive
     * @param Application $app
     * @param Compiler $blade
     * @return mixed
     */
    public function openForeach($value, $directive, Application $app, Compiler $blade)
    {
        $matcher = '/(?<!\w)(\s*)@foreach(?:\s*)\((.*)(?:\sas)(.*)\)/';

        return preg_replace($matcher, $directive, $value);
    }

    /**
     * Ends `foreach` directive
     *
     * @param             $value
     * @param             $directive
     * @param Application $app
     * @param Compiler $blade
     * @return mixed
     */
    public function closeForeach($value, $directive, Application $app, Compiler $blade)
    {
        $matcher = $this->createPlainMatcher('endforeach');

        return preg_replace($matcher, $directive, $value);
    }

    /**
     * Adds `break` directive
     *
     * @param             $value
     * @param             $directive
     * @param Application $app
     * @param Compiler $blade
     * @return mixed
     */
    public function addBreak($value, $directive, Application $app, Compiler $blade)
    {
        $matcher = $this->createPlainMatcher('break');

        return preg_replace($matcher, $directive, $value);
    }

    /**
     * Adds `continue` directive
     *
     * @param             $value
     * @param             $directive
     * @param Application $app
     * @param Compiler $blade
     * @return mixed
     */
    public function addContinue($value, $directive, Application $app, Compiler $blade)
    {
        $matcher = $this->createPlainMatcher('continue');

        return preg_replace($matcher, $directive, $value);
    }
}
