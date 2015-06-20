<?php
/**
 * Directives: macro, endmacro, domacro
 */
namespace Radic\BladeExtensions\Directives;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\View\Compilers\BladeCompiler as Compiler;
use Radic\BladeExtensions\Traits\BladeExtenderTrait;

/**
 * Directives: macro, endmacro, domacro
 *
 * @package                Radic\BladeExtensions
 * @subpackage             Directives
 * @version                2.1.0
 * @author                 Robin Radic
 * @license                MIT License - http://radic.mit-license.org
 * @copyright              2011-2015, Robin Radic
 * @link                   http://robin.radic.nl/blade-extensions
 *
 */
class MacroDirectives
{
    use BladeExtenderTrait;


    /**
     * Starts `macro` directive
     *
     * @param             $value
     * @param             $configured
     * @param Application $app
     * @param Compiler $blade
     * @return mixed
     */
    public function openMacro($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = '/(?<!\w)(\s*)@macro(?:\s*)\((?:\s*)[\'"]([\w\d]*)[\'"],(.*)\)/';

        return preg_replace($matcher, $configured, $value);
    }

    /**
     * Ends `macro` directive
     *
     * @param             $value
     * @param             $configured
     * @param Application $app
     * @param Compiler $blade
     * @return mixed
     */
    public function closeMacro($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = $this->createPlainMatcher('endmacro');

        return preg_replace($matcher, $configured, $value);
    }

    /**
     * Adds `domacro` directive.
     * Executes a macro
     *
     * @param             $value
     * @param             $configured
     * @param Application $app
     * @param Compiler $blade
     * @return mixed
     */
    public function doMacro($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = '/(?<!\w)(\s*)@domacro(?:\s*)\((?:\s*)[\'"]([\w\d]*)[\'"],(.*)\)/';

        return preg_replace($matcher, $configured, $value);
    }
}
