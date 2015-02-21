<?php namespace Radic\BladeExtensions\Compilers;


use Ciconia\Ciconia;
use Ciconia\Extension\Gfm;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\Compiler;
use Illuminate\View\Compilers\CompilerInterface;
use Radic\BladeExtensions\Contracts\MarkdownRenderer;

class MarkdownCompiler extends Compiler implements CompilerInterface
{

    /**
     * @var \Radic\BladeExtensions\Contracts\MarkdownRenderer
     */
    protected $renderer;

    /**
     * Create a new instance
     *
     * @param Ciconia    $renderer
     * @param Filesystem $files
     * @param            $cachePath
     */
    public function __construct(MarkdownRenderer $renderer, Filesystem $files, $cachePath)
    {
        parent::__construct($files, $cachePath);
        $this->renderer = $renderer;
    }

    /**
     * Compile the view at the given path.
     *
     * @param  string $path
     * @return void
     */
    public function compile($path)
    {
        $content = $this->renderer->render($this->files->get($path));
        $this->files->put($this->getCompiledPath($path), $content);
    }

    public function getRenderer()
    {
        return $this->renderer;
    }

    public function setRenderer($renderer)
    {
        $this->renderer = $renderer;

        return $this;
    }



    public function getFiles()
    {
        return $this->files;
    }

    public function setFiles($files)
    {
        $this->files = $files;

        return $this;
    }

    public function getCachePath()
    {
        return $this->cachePath;
    }

    public function setCachePath($cachePath)
    {
        $this->cachePath = $cachePath;

        return $this;
    }


}
