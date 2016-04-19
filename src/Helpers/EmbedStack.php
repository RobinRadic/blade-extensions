<?php
/**
 * Manages the Loop instances
 */
namespace Radic\BladeExtensions\Helpers;

use Sebwite\Support\Path;
use Sebwite\Support\Str;
use Illuminate\Filesystem\Filesystem;
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
class EmbedStack implements Stack, Factory
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
            $name = str_slug($this->viewPath) . '__' . uniqid(time(), true);
        }
        $path = path_join($tmpDir, $name);
        $this->files->put($path, $content);

        return [ $name, $path ];
    }

    protected function remove($name)
    {
        $tmpDir = storage_path('blade-extensions');
        $path   = path_join($tmpDir, $name);
        $this->files->delete($path);
        return $this;
    }


    /**
     * Determine if a given view exists.
     *
     * @param  string $view
     * @return bool
     */
    public function exists($view)
    {
        return call_user_func_array([$this->viewFactory, 'exists'], func_get_args());
    }

    /**
     * Get the evaluated view contents for the given path.
     *
     * @param  string $path
     * @param  array  $data
     * @param  array  $mergeData
     * @return \Illuminate\Contracts\View\View
     */
    public function file($path, $data = [ ], $mergeData = [ ])
    {
        return call_user_func_array([$this->viewFactory, 'file'], func_get_args());
    }

    /**
     * Get the evaluated view contents for the given view.
     *
     * @param  string $view
     * @param  array  $data
     * @param  array  $mergeData
     * @return \Illuminate\Contracts\View\View
     */
    public function make($view, $data = [ ], $mergeData = [ ])
    {
        return call_user_func_array([$this->viewFactory, 'make'], func_get_args());
    }

    /**
     * Add a piece of shared data to the environment.
     *
     * @param  array|string $key
     * @param  mixed        $value
     * @return mixed
     */
    public function share($key, $value = null)
    {
        return call_user_func_array([$this->viewFactory, 'share'], func_get_args());
    }

    /**
     * Register a view composer event.
     *
     * @param  array|string    $views
     * @param  \Closure|string $callback
     * @param  int|null        $priority
     * @return array
     */
    public function composer($views, $callback, $priority = null)
    {
        return call_user_func_array([$this->viewFactory, 'composer'], func_get_args());
    }

    /**
     * Register a view creator event.
     *
     * @param  array|string    $views
     * @param  \Closure|string $callback
     * @return array
     */
    public function creator($views, $callback)
    {
        return call_user_func_array([$this->viewFactory, 'creator'], func_get_args());
    }

    /**
     * Add a new namespace to the loader.
     *
     * @param  string       $namespace
     * @param  string|array $hints
     * @return void
     */
    public function addNamespace($namespace, $hints)
    {
        return call_user_func_array([$this->viewFactory, 'addNamespace'], func_get_args());
    }
}
