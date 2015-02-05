<?php namespace Radic\BladeExtensions\Directives;

use Illuminate\Foundation\Application;
use Illuminate\View\Compilers\BladeCompiler as Compiler;
use Radic\BladeExtensions\Traits\BladeExtenderTrait;

/**
 * Macro directives
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
class MacroDirective
{
    use BladeExtenderTrait;

    /**
     * Starts `macro` directive
     *
     * @param             $value
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function openMacro($value, Application $app, Compiler $blade)
    {
        //$matcher = '/@macro\([\'\"](\w*)[\'\"]\)/';

        $matcher = '/@macro\([\'"]([\w\d]*)[\'"],(.*)\)/';

        return preg_replace($matcher, '<?php HTML::macro("$1", function($2){ ', $value);
    }

    /**
     * Ends `macro` directive
     *
     * @param             $value
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function closeMacro($value, Application $app, Compiler $blade)
    {
        $matcher = $blade->createPlainMatcher('endmacro');

        return preg_replace($matcher, '  });  ?>', $value);
    }

    /**
     * Adds `domacro` directive.
     * Executes a macro
     *
     * @param             $value
     * @param Application $app
     * @param Compiler    $blade
     * @return mixed
     */
    public function doMacro($value, Application $app, Compiler $blade)
    {
        $matcher = '/@domacro\([\'"]([\w\d]*)[\'"],(.*)\)/';

        return preg_replace($matcher, '<?php echo HTML::$1($2); ?>', $value);
    }
}
