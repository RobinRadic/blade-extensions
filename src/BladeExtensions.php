<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2017 (c) Robin Radic
 * @license https://radic.mit-license.org The MIT License
 */

namespace Radic\BladeExtensions;

use Closure;
use Illuminate\Filesystem\Filesystem;
use Illuminate\View\Compilers\BladeCompiler;

class BladeExtensions
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
     * @param \Illuminate\Contracts\Foundation\Application $app
     * @param \Radic\BladeExtensions\DirectiveRegistry     $directives
     * @param \Radic\BladeExtensions\HelperRepository      $helpers
     * @param \Illuminate\View\Compilers\BladeCompiler     $compiler
     */
    public function __construct(DirectiveRegistry $directives, HelperRepository $helpers)
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
     * Compile blade syntax to string.
     *
     * @param string $string String with blade syntax to compile
     * @param array  $vars   Optional variables
     *
     * @return string
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
     * pushToStack method.
     *
     * @param string          $stackName   The name of the stack
     * @param string|string[] $targetViews The view which contains the stack
     * @param string|Closure  $content     the content to push
     *
     * @return $this
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
     * @return bool
     */
    public function isHooked()
    {
        return $this->hooked;
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
