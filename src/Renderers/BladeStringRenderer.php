<?php
/**
 * Part of the Robin Radic's PHP packages.
 *
 * MIT License and copyright information bundled with this package
 * in the LICENSE file or visit http://radic.mit-license.com
 */
namespace Radic\BladeExtensions\Renderers;


use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\Contracts\Filesystem\Filesystem;

/**
 * This is the BladeStringRenderer.
 *
 * @package        Radic\BladeExtensions
 * @author         Robin Radic
 * @license        MIT License
 * @copyright      2015, Robin Radic
 * @link           https://github.com/robinradic
 */
class BladeStringRenderer
{
    /**
     * @var \Illuminate\View\Compilers\BladeCompiler
     */
    protected $compiler;

    /**
     * Path to the temporary file
     * @var string
     */
    protected $tmpFilePath;

    /**
     * @var \Caffeinated\Beverage\Filesystem
     */
    protected $files;

    /**
     * @param \Illuminate\View\Compilers\BladeCompiler    $compiler
     * @param \Illuminate\Contracts\Filesystem\Filesystem $files
     */
    public function __construct(BladeCompiler $compiler, Filesystem $files)
    {
        $this->compiler = $compiler;
        $this->files = $files;
        $this->tmpFilePath = storage_path(uniqid(time(), true));
    }

    /**
     * render
     *
     * @param       $string
     * @param array $vars
     * @return string
     */
    public function render($string, array $vars = array())
    {
        $this->files->put($this->tmpFilePath, $this->compiler->compileString($string));

        if (is_array($vars) && !empty($vars)) {
            extract($vars);
        }


        ob_start();
        include($this->tmpFilePath);
        $var=ob_get_contents();
        ob_end_clean();

        $this->files->delete($this->tmpFilePath);
        return $var;
    }

    /**
     * get tmpFilePath value
     *
     * @return mixed
     */
    public function getTmpFilePath()
    {
        return $this->tmpFilePath;
    }

    /**
     * Set the tmpFilePath value
     *
     * @param mixed $tmpFilePath
     * @return BladeStringRenderer
     */
    public function setTmpFilePath($tmpFilePath)
    {
        $this->tmpFilePath = $tmpFilePath;

        return $this;
    }

    /**
     * get files value
     *
     * @return \Caffeinated\Beverage\Filesystem
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Set the files value
     *
     * @param \Caffeinated\Beverage\Filesystem $files
     * @return BladeStringRenderer
     */
    public function setFiles(Filesystem $files)
    {
        $this->files = $files;

        return $this;
    }


}
