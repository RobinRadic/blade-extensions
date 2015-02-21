<?php namespace Radic\BladeExtensions\Engines;


use Ciconia\Ciconia;
use Ciconia\Extension\Gfm;
use Illuminate\View\Compilers\CompilerInterface;
use Illuminate\View\Engines\CompilerEngine;
use Radic\BladeExtensions\Contracts\MarkdownRenderer;


/**
 * The blade markdown engine
 *
 * @package            Radic\BladeExtensions
 * @version            2.1.0
 * @subpackage         Engines
 * @author             Robin Radic
 * @license            MIT License - http://radic.mit-license.org
 * @copyright          (c) 2011-2015, Robin Radic
 * @link               http://robin.radic.nl/blade-extensions
 *
 */
class BladeMarkdownEngine extends CompilerEngine
{

    /** @var \Radic\BladeExtensions\Contracts\MarkdownRenderer */
    protected $renderer;

    /**
     * Create a new instance.
     *
     * @param CompilerInterface $compiler
     * @param MarkdownRenderer $renderer
     */
    public function __construct(CompilerInterface $compiler, MarkdownRenderer $renderer)
    {
        parent::__construct($compiler);
        $this->renderer = $renderer;
    }

    /**
     * Get the rendered contents
     *
     * @param string $path
     * @param array $data
     * @return mixed
     */
    public function get($path, array $data = [])
    {
        $contents = parent::get($path, $data);

        return $this->renderer->render($contents);
    }

    /**
     * Get the renderer
     * @return \Radic\BladeExtensions\Contracts\MarkdownRenderer
     */
    public function getRenderer()
    {
        return $this->renderer;
    }

    /**
     * Sets the renderer
     * @param MarkdownRenderer $renderer
     * @return BladeMarkdownEngine $this
     */
    public function setRenderer(MarkdownRenderer $renderer)
    {
        $this->renderer = $renderer;

        return $this;
    }
}
