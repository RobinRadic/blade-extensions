<?php
/**
 * Directives: set, unset
 */
namespace Radic\BladeExtensions\Directives;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\View\Compilers\BladeCompiler as Compiler;
use Radic\BladeExtensions\Traits\BladeExtenderTrait;

/**
 * Directives: set, unset
 * @package                Radic\BladeExtensions
 * @subpackage             Directives
 * @version                2.1.0
 * @author                 Robin Radic
 * @license                MIT License - http://radic.mit-license.org
 * @copyright              2011-2015, Robin Radic
 * @link                   http://robin.radic.nl/blade-extensions
 */
class AssignmentDirectives
{

    use BladeExtenderTrait;

    /**
     * Adds `set` directive
     *
     * @param             $value
     * @param             $configured
     * @param Application $app
     * @param Compiler $blade
     * @return mixed
     */
    public function addSet($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = '/(?<!\w)(\s*)@set(?:\s*)\((?:\s*)(?:\$|(?:\'|\"|))(.*?)(?:\'|\"|),(?:\s|)(.*)\)/';

        return preg_replace($matcher, $configured, $value);
    }

    /**
     * Adds `unset` directive
     *
     * @param             $value
     * @param             $configured
     * @param Application $app
     * @param Compiler $blade
     * @return mixed
     */
    public function addUnset($value, $configured, Application $app, Compiler $blade)
    {
        $matcher = '/(?<!\w)(\s*)@unset(?:\s*)\((?:\s*)(?:\$|(?:\'|\"|))(.*?)(?:\'|\"|)(?:\s*)\)/';

        return preg_replace($matcher, $configured, $value);
    }
}
