<?php
/**
 * Part of the Laradic packages.
 */
namespace Radic\BladeExtensions\Helpers;

use Caffeinated\Beverage\Path;
use Caffeinated\Beverage\Str;
use Illuminate\Contracts\View\Factory as ViewFactory;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;
use Radic\BladeExtensions\Traits\SectionsTrait;

/**
 * Class Factory
 *
 * @package     Radic\BladeExtensions\Widgets
 * @author      Robin Radic
 * @license     MIT
 * @copyright   2011-2015, Robin Radic
 * @link        http://radic.mit-license.org
 */
class EmbedFactory2
{
    use SectionsTrait;

    /**
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * @var \Illuminate\View\Compilers\BladeCompiler
     */
    protected $bladeCompiler;

    /**
     * @var array
     */
    protected $vars;

    /**
     * @var string
     */
    protected $viewPath;

    protected $out;

    /**
     * __call
     *
     * @param $name
     * @param $arguments
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        if ( method_exists($this->viewFactory, $name) )
        {
            return call_user_func_array([ $this->viewFactory, $name ], $arguments);
        }
    }

    /**
     * Instantiates the class
     *
     * @param \Illuminate\Contracts\View\Factory       $viewFactory
     * @param \Illuminate\Filesystem\Filesystem        $files
     * @param \Illuminate\View\Compilers\BladeCompiler $bladeCompiler
     */
    public function __construct(ViewFactory $viewFactory, Filesystem $files, BladeCompiler $bladeCompiler)
    {
        $this->setViewFactory($viewFactory);
        $this->files         = $files;
        $this->bladeCompiler = $bladeCompiler;
    }

    /**
     * open
     *
     * @param       $viewPath
     * @param array $vars
     * @return $this
     */
    public function open($viewPath, array $vars = [ ])
    {
        $this->viewPath = $viewPath;
        $this->vars     = $vars;


        return $this;
    }

    public function close()
    {

    }

    public function write($content, $name = null)
    {

        $tmpDir = storage_path('blade-extensions');
        if ( ! $this->files->exists($tmpDir) )
        {
            $this->files->makeDirectory($tmpDir, 0755, true);
        }
        if ( is_null($name) )
        {
            $name = Str::slugify($this->viewPath) . '__' . uniqid(time(), true);
        }
        $path = Path::join($tmpDir, $name);
        $this->files->put($path, $content);

        return [$name, $path];
    }

    public function remove($name)
    {
        $tmpDir = storage_path('blade-extensions');
        $path = Path::join($tmpDir, $name);
        $this->files->delete($path);
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
}
