<?php
/**
 * Part of the Laradic packages.
 */
namespace Radic\BladeExtensions\Helpers;

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
class EmbedFactory
{
    use SectionsTrait;

    protected $files;

    protected $bladeCompiler;

    protected $vars;

    protected $viewPath;

    public function __call($name, $arguments)
    {
        if (method_exists($this->viewFactory, $name)) {
            return call_user_func_array([$this->viewFactory, $name], $arguments);
        }
    }


    /**
     * Instantiates the class
     *
     * @param \Illuminate\Contracts\View\Factory $viewFactory
     * @param \Illuminate\Filesystem\Filesystem  $files
     */
    public function __construct(ViewFactory $viewFactory, Filesystem $files, BladeCompiler $bladeCompiler)
    {
        $this->setViewFactory($viewFactory);
        $this->files         = $files;
        $this->bladeCompiler = $bladeCompiler;
    }

    public function open($viewPath, array $vars = [ ])
    {
        $this->viewPath = $viewPath;
        $this->vars     = $vars;


        return $this;
    }

    public function insert($bladeCompiledContent)
    {
        $path = storage_path(uniqid(time(), true));
        $this->files->put($path, $bladeCompiledContent);
        $vars = $this->vars;
        extract($vars);
        $__env = $this;
        ob_start();
        include($path);
        $this->files->delete($path);
        $originalContent = ob_get_clean();

        $path = storage_path(uniqid(time(), true));
        $this->files->put($path, $this->getBladeCompiledViewFileContent());
        ob_start();
        include($path);
        $this->files->delete($path);
        $out = ob_get_clean();

        return $this->recurse($out);
    }

    public function recurse($out)
    {
        preg_match_all('/(?<!\w)(\s*)@embed\s*(\([^)]*\))((?>(?!@(?:end)?embed).|(?0))*)@endembed/s', $out, $matches);
        if (count($matches[ 0 ]) > 0) {
            $path = storage_path(uniqid(time(), true));
            $this->files->put($path, $this->bladeCompiler->compileString($out));
            $vars = $this->vars;
            extract($vars);
            $__env = $this;
            ob_start();
            include($path);
            $this->files->delete($path);
            $out = ob_get_clean();
            $this->flushSections();

            return $this->recurse($out);
        }
        echo $out;

        return $this;
    }

    public function close()
    {
        $this->flushSections();

        return $this;
    }

    protected function getAbsoluteViewPath()
    {
        return $this->getViewFactory()->getFinder()->find($this->viewPath);
    }

    protected function getViewFileContent()
    {
        return $this->files->get($this->getAbsoluteViewPath());
    }

    protected function getBladeCompiledViewFileContent()
    {
        return $this->bladeCompiler->compileString($this->getViewFileContent());
    }
}
