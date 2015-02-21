<?php namespace Radic\BladeExtensions\Engines;



use Illuminate\View\Compilers\CompilerInterface;
use Illuminate\View\Engines\CompilerEngine;

use Ciconia\Ciconia;
use Ciconia\Extension\Gfm;
use Radic\BladeExtensions\Traits\MarkdownEngineTrait;


class BladeMarkdownEngine extends CompilerEngine
{
    protected $ciconia;

    /**
     * Create a new instance.
     *
     * @param CompilerInterface $compiler
     * @param Ciconia       $ciconia
     */
    public function __construct(CompilerInterface $compiler, Ciconia $ciconia)
    {
        parent::__construct($compiler);
        $this->ciconia = $ciconia;
    }


    public function get($path, array $data = [])
    {
        $contents = parent::get($path, $data);
        return $this->ciconia->render($contents);
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

}
