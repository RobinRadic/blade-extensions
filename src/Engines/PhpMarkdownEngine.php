<?php
/**
 * The Parsedown markdown renderer implementation
 */
namespace Radic\BladeExtensions\Engines;

use Ciconia\Extension\Gfm;
use Illuminate\View\Engines\PhpEngine;
use Radic\BladeExtensions\Contracts\MarkdownRenderer;

/**
 * The Parsedown markdown renderer implementation
 *
 * @package            Radic\BladeExtensions
 * @subpackage         Engines
 * @version            2.1.0
 * @author             Robin Radic
 * @license            MIT License - http://radic.mit-license.org
 * @copyright          2011-2015, Robin Radic
 * @link               http://robin.radic.nl/blade-extensions
 *
 */
class PhpMarkdownEngine extends PhpEngine
{

    /**
     * The markdown renderer implementation
     * @var \Radic\BladeExtensions\Contracts\MarkdownRenderer
     */
    protected $renderer;

    /**
     * Create a new instance.
     *
     * @param \Radic\BladeExtensions\Contracts\MarkdownRenderer $renderer
     */
    public function __construct(MarkdownRenderer $renderer)
    {
        $this->setRenderer($renderer);
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

        return $this->getRenderer()->render($contents);
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
