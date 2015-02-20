<?php namespace Radic\BladeExtensions\Engines;



use Ciconia\Ciconia;
use Ciconia\Extension\Gfm;
use Illuminate\View\Engines\PhpEngine;
use Radic\BladeExtensions\Traits\MarkdownEngineTrait;


class PhpMarkdownEngine extends PhpEngine
{
    protected $ciconia;

    /**
     * Create a new instance.
     *
     * @param CompilerInterface $compiler
     * @param Ciconia       $ciconia
     */
    public function __construct(Ciconia $ciconia, $gfm = false)
    {
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
