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
class MacroDirective
{
    use BladeExtenderTrait;


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

    public function doMacro($value, Application $app, Compiler $blade)
    {
        $matcher = '/@domacro\([\'"]([\w\d]*)[\'"],(.*)\)/';

        return preg_replace($matcher, '<?php echo HTML::$1($2); ?>', $value);
    }
}
