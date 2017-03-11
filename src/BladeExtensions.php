<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright 2017 Robin Radic
 * @license https://radic.mit-license.org MIT License
 * @version 7.0.0 Radic\BladeExtensions
 */

namespace Radic\BladeExtensions;

use Closure;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;

/**
 * {@inheritdoc}
 */
class BladeExtensions implements Contracts\BladeExtensions
{
    /** @var \Illuminate\View\Compilers\BladeCompiler */
    protected $compiler;

    /** @var \Radic\BladeExtensions\DirectiveRegistry */
    protected $directives;

    /** @var \Radic\BladeExtensions\HelperRepository */
    protected $helpers;

    /** @var \Illuminate\Filesystem\Filesystem */
    protected $fs;

    /** @var string */
    protected $cachePath;

    /**
     * BladeExtensions constructor.
     *
     * @param \Radic\BladeExtensions\Contracts\DirectiveRegistry|\Radic\BladeExtensions\DirectiveRegistry $directives
     * @param \Radic\BladeExtensions\Contracts\HelperRepository|\Radic\BladeExtensions\HelperRepository   $helpers
     */
    public function __construct(Contracts\DirectiveRegistry $directives, Contracts\HelperRepository $helpers)
    {
        $this->directives = $directives;
        $this->helpers = $helpers;
        $this->fs = new Filesystem;
        $this->cachePath = storage_path('blade-extensions');
    }

    /**
     * getCompiler method.
     * @return \Illuminate\View\Compilers\BladeCompiler
     */
    protected function getCompiler()
    {
        if (! isset($this->compiler)) {
            if ($this->fs->exists($this->cachePath) === false) {
                $this->fs->makeDirectory($this->cachePath);
            }
            $this->compiler = new BladeCompiler($this->fs, $this->cachePath);
        }

        return $this->compiler;
    }

    /**
     * {@inheritdoc}
     */
    public function compileString($string, array $vars = [])
    {
        if (empty($vars)) {
            return $this->getCompiler()->compileString($string);
        }
        $fileName = uniqid('compileString', true).'.php';
        $filePath = $this->cachePath.DIRECTORY_SEPARATOR.$fileName;
        $string = $this->getCompiler()->compileString($string);
        $this->fs->put($filePath, $string);
        $compiledString = $this->getCompiledContent($filePath, $vars);
        $this->fs->delete($filePath);

        return $compiledString;
    }

    /**
     * getCompiledContent method.
     *
     * @param       $filePath
     * @param array $vars
     *
     * @return string
     */
    protected function getCompiledContent($filePath, array $vars = [])
    {
        if (is_array($vars) && ! empty($vars)) {
            extract($vars, EXTR_OVERWRITE);
        }
        ob_start();
        include $filePath;
        $var = ob_get_contents();
        ob_end_clean();

        return $var;
    }

    /**
     * {@inheritdoc}
     */
    public function pushToStack($stackName, $targetViews, $content)
    {
        $targetViews = is_array($targetViews) ? $targetViews : [$targetViews];
        foreach ($targetViews as $targetView) {
            app()->make('events')->listen('composing: '.$targetView, function ($view) use ($stackName, $content) {
                $content = $content instanceof Closure ? $content($view) : $content;
                if (method_exists($view, 'getFactory') && method_exists($view->getFactory(), 'startPush')) {
                    $view->getFactory()->startPush($stackName, $content);
                }
            });
        }

        return $this;
    }

    /**
     * @return \Radic\BladeExtensions\DirectiveRegistry
     */
    public function getDirectives()
    {
        return $this->directives;
    }

    /**
     * @return \Radic\BladeExtensions\HelperRepository
     */
    public function getHelpers()
    {
        return $this->helpers;
    }
}
