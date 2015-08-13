<?php
/**
 * Part of the Robin Radic's PHP packages.
 *
 * MIT License and copyright information bundled with this package
 * in the LICENSE file or visit http://radic.mit-license.com
 */
namespace Radic\BladeExtensions\Renderers;

use Illuminate\View\Compilers\BladeCompiler;
use Caffeinated\Beverage\Filesystem;

/**
 * This is the BladeStringRenderer.
 *
 * @package        Radic\BladeExtensions
 * @version        1.0.0
 * @author         Robin Radic
 * @license        MIT License
 * @copyright      2015, Robin Radic
 * @link           https://github.com/robinradic
 */
class BladeStringRenderer
{
    protected $compiler;

    protected $tmpDir;

    protected $files;

    /** Instantiates the class
     *
     * @param \Illuminate\View\Compilers\BladeCompiler $compiler
     * @param \Caffeinated\Beverage\Filesystem         $files
     */
    public function __construct(BladeCompiler $compiler, Filesystem $files)
    {
        $this->compiler = $compiler;
        $this->files = $files;
    }

    public function render($string, array $vars = array())
    {
        $fileName = uniqid(time(), true);
        $path = storage_path($fileName);
        $this->files->put($path, $this->compiler->compileString($string));

        if (is_array($vars) && !empty($vars)) {
            extract($vars);
        }


        ob_start();
        include($path);
        $var=ob_get_contents();
        ob_end_clean();

        $this->files->delete($path);
        return $var;

    }
}
