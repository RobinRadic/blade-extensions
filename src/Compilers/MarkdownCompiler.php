<?php
/**
 * Markdown compiler
 */
namespace Radic\BladeExtensions\Compilers;

use Ciconia\Extension\Gfm;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\Compiler;
use Illuminate\View\Compilers\CompilerInterface;
use Radic\BladeExtensions\Contracts\MarkdownRenderer;

/**
 * Markdown compiler
 *
 * @package            Radic\BladeExtensions
 * @subpackage         Compilers
 * @version            2.1.0
 * @author             Robin Radic
 * @license            MIT License - http://radic.mit-license.org
 * @copyright          2011-2015, Robin Radic
 * @link               http://robin.radic.nl/blade-extensions
 *
 */
class MarkdownCompiler extends Compiler implements CompilerInterface
{

    /**
     * The markdown render instance
     * @var \Radic\BladeExtensions\Contracts\MarkdownRenderer
     */
    protected $renderer;

    /**
     * Create a new instance
     *
     * @param \Radic\BladeExtensions\Contracts\MarkdownRenderer $renderer
     * @param \Illuminate\Filesystem\Filesystem $files
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

    /**
     * @return MarkdownRenderer
     */
    public function getRenderer()
    {
        return $this->renderer;
    }
}
