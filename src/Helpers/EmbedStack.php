<?php
/**
 * Manages the Loop instances
 */
namespace Radic\BladeExtensions\Helpers;

use Caffeinated\Beverage\Path;
use Caffeinated\Beverage\Str;
use Caffeinated\Beverage\Filesystem;
use Illuminate\Contracts\View\Factory;
use Illuminate\View\Compilers\BladeCompiler;
use Radic\BladeExtensions\Contracts\Stack;
use Radic\BladeExtensions\Traits\SectionsTrait;

/**
 * Manages the Loop instances
 *
 * @package        Radic\BladeExtensions
 * @subpackage     Helpers
 * @version        2.1.0
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright      (2011-2014, Robin Radic - Radic Technologies
 * @link           http://robin.radic.nl/blade-extensions
 *
 */
class EmbedStack implements Stack
{
    use SectionsTrait;

    protected $files;

    protected $bladeCompiler;

    protected $viewPath;

    protected $vars;

    protected $content;

    protected $_data;

    public function __construct(Factory $viewFactory, Filesystem $files, BladeCompiler $bladeCompiler, $viewPath, $vars = [ ])
    {
        $this->setViewFactory($viewFactory);
        $this->files         = $files;
        $this->bladeCompiler = $bladeCompiler;
        $this->viewPath      = $viewPath;
        $this->vars          = $vars;
    }


    public function setData($_data)
    {
        $this->_data = $_data;
        return $this;
    }

    public function start()
    {
        return $this;
    }

    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }

    public function end()
    {
        $content = $this->bladeCompiler->compileString($this->content);
        $viewContent = $this->getBladeCompiledViewFileContent();
        list($name, $path) = $this->write($content . $viewContent);
        extract($this->_data);
        $__data = $this->_data;
        $__env = $this;
        extract($this->vars);
        ob_start();
        include($path);
        $this->remove($name);
        $out = ob_get_clean();
        echo $out;

        return $this;
    }


    /**
     * getAbsoluteViewPath
     *
     * @return string
     */
    protected function getAbsoluteViewPath()
    {
        return $this->getViewFactory()->getFinder()->find($this->viewPath);
    }

    /**
     * getViewFileContent
     *
     * @return string
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function getViewFileContent()
    {
        return $this->files->get($this->getAbsoluteViewPath());
    }

    /**
     * getBladeCompiledViewFileContent
     *
     * @return string
     */
    protected function getBladeCompiledViewFileContent()
    {
        return $this->bladeCompiler->compileString($this->getViewFileContent());
    }


    protected function write($content, $name = null)
    {

        $tmpDir = storage_path('blade-extensions');
        if (! $this->files->exists($tmpDir)) {
            $this->files->makeDirectory($tmpDir);
        }
        if (is_null($name)) {
            $name = Str::slugify($this->viewPath) . '__' . uniqid(time(), true);
        }
        $path = Path::join($tmpDir, $name);
        $this->files->put($path, $content);

        return [ $name, $path ];
    }

    protected function remove($name)
    {
        $tmpDir = storage_path('blade-extensions');
        $path   = Path::join($tmpDir, $name);
        $this->files->delete($path);
        return $this;
    }
}
