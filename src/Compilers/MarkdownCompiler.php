<?php namespace Radic\BladeExtensions\Compilers;


use Ciconia\Ciconia;
use Ciconia\Extension\Gfm;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\Compiler;
use Illuminate\View\Compilers\CompilerInterface;

class MarkdownCompiler extends Compiler implements CompilerInterface
{

    /**
     * @var Ciconia
     */
    protected $ciconia;

    /**
     * Create a new instance
     *
     * @param Ciconia    $ciconia
     * @param Filesystem $files
     * @param            $cachePath
     */
    public function __construct(Ciconia $ciconia, Filesystem $files, $cachePath)
    {
        parent::__construct($files, $cachePath);
        $this->ciconia = $ciconia;
    }

    /**
     * Compile the view at the given path.
     *
     * @param  string $path
     * @return void
     */
    public function compile($path)
    {
        $content = $this->ciconia->render($this->files->get($path));
        $this->files->put($this->getCompiledPath($path), $content);
    }


    public function getCiconia()
    {
        return $this->ciconia;
    }

    public function setCiconia($ciconia)
    {
        $this->ciconia = $ciconia;

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
