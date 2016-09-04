<?php
/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 8/7/16
 * Time: 1:39 AM
 */
namespace Radic\BladeExtensions\Seven;

use Illuminate\Contracts\Foundation\Application;

class Factory
{
    const MODE_AUTO = 'auto';
    const MODE_CUSTOM = 'custom';
    const MODE_DISABLED = 'disabled';

    /** @var DirectiveRegistry */
    protected $directives;

    /**
     * @var string
     */
    protected $mode = self::MODE_AUTO;

    /** @var Application */
    protected $app;

    /**
     * @var string|\Closure
     */
    protected $customModeHandler;

    /**
     * @var \Illuminate\View\Compilers\Compiler|\Illuminate\View\Compilers\BladeCompiler
     */
    protected $blade;

    /**
     * @var bool
     */
    protected $hooked = false;


    /**
     * Factory constructor.
     *
     * @param \Illuminate\Contracts\Foundation\Application   $app
     * @param \Radic\BladeExtensions\Seven\DirectiveRegistry $directives
     */
    public function __construct(Application $app, DirectiveRegistry $directives)
    {
        $this->app        = $app;
        $this->directives = $directives;
    }

    public function hookToCompiler()
    {
        if ( true === $this->hooked ) {
            return;
        }
        $this->hooked = true;
        $this->app->booted(function ($app) {
            if ( $this->mode === self::MODE_DISABLED ) {
                return;
            }
            if ( $this->mode === self::MODE_AUTO ) {
                $this->handleAutoMode();
            } elseif ( $this->mode === self::MODE_CUSTOM ) {
                $this->handleCustomMode();
            } else {
                throw new \RuntimeException('BladeExtensions Factory $mode not valid');
            }
        });
    }

    /**
     * @param Application $app
     */
    protected function handleAutoMode()
    {
        $this->getCompiler()->extend(function ($value) {
            foreach ( $this->directives->getNames() as $name ) {
                $value = $this->directives->call($name, [ $value ]);
            }
            return $value;
        });
    }

    /**
     * @param Application $app
     */
    protected function handleCustomMode()
    {
        if ( null === $this->customModeHandler ) {
            throw new \RuntimeException('[Custom Mode Handler Not Set]');
        }
        $this->app->call($this->customModeHandler, [ ], 'handle');
    }

    /**
     * @return \Illuminate\View\Compilers\BladeCompiler
     */
    public function getCompiler()
    {
        return $this->blade ?: $this->blade = $this->app->make('view')->getEngineResolver()->resolve('blade')->getCompiler();
    }

    /**
     * @return \Radic\BladeExtensions\Seven\DirectiveRegistry
     */
    public function getDirectives()
    {
        return $this->directives;
    }

    /**
     * @return string
     */
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * @param string $mode
     */
    public function setMode($mode)
    {
        $this->mode = $mode;
    }

    public function setCustomModeHandler($handler)
    {
        $this->customModeHandler = $handler;
    }


}
