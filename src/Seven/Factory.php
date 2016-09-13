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


    /** @var Application */
    protected $app;

    /**
     * @var \Illuminate\View\Compilers\Compiler|\Illuminate\View\Compilers\BladeCompiler
     */
    protected $blade;

    /**
     * @var bool
     */
    protected $hooked = false;

    protected $hook;

    /**
     * helpers method
     *
     * @var \Illuminate\Support\Collection
     */
    protected $helpers;

    /**
     * directives method
     *
     * @var \Illuminate\Support\Collection
     */
    protected $directives;

    /**
     * directiveOverrides method
     *
     * @var array
     */
    protected $directiveOverrides = [];

    /**
     * laravelVersion
     *
     * @var string
     */
    protected $laravelVersion = \Illuminate\Foundation\Application::VERSION;


    /**
     * Factory constructor.
     *
     * @param \Illuminate\Contracts\Foundation\Application   $app
     * @param \Radic\BladeExtensions\Seven\DirectiveRegistry $directives
     */
    public function __construct(Application $app)
    {
        $this->app        = $app;
        $this->directives = collect(); //new DirectiveRegistry($app, $this);
        $this->helpers    = collect();
    }

    /**
     * @return string
     */
    public function setHook($hook)
    {
        $this->hook = $hook;
    }

    /**
     * @return boolean
     */
    public function isHooked()
    {
        return $this->hooked;
    }

    public function hookToCompiler()
    {
        if ( true === $this->hooked ) {
            return;
        }
        $this->hooked = true;
        $this->app->booted(function ($app) {

            // call custom hook function
            if ( $this->hook ) {
                return $this->app->call($this->hook, [ $this ], 'handle');
            }

            $this->getCompiler()->extend(function ($value) {
                foreach ( $this->directives->keys()->toArray() as $name ) {
                    $value = $this->getResolvedDirective($name, [ $value ]);
                }
                return $value;
            });
        });
    }

    /**
     * @return \Illuminate\View\Compilers\BladeCompiler
     */
    public function getCompiler()
    {
        return $this->blade ?: $this->blade = $this->app->make('view')->getEngineResolver()->resolve('blade')->getCompiler();
    }

    /**
     * getHelpers method
     *
     * @return \Illuminate\Support\Collection
     */
    public function getHelpers()
    {
        return $this->helpers;
    }

    /**
     * getDirectives method
     *
     * @return \Illuminate\Support\Collection
     */
    public function getDirectives()
    {
        return $this->directives;
    }

    /**
     * setVersionOverrides method
     *
     * @param array $versionOverrides
     *
     * @return static|void|null
     */
    public function setVersionOverrides($versionOverrides)
    {
        // if used outside of laravel framework (ie with illuminate/views) we ignore the version overrides completely.
        if ( false === class_exists('Illuminate\Foundation\Application', false) ) {
            return;
        }
        list($laravelMajor, $laravelMinor) = explode('.', \Illuminate\Foundation\Application::VERSION);
        foreach ( $versionOverrides as $version => $overrides ) {
            list($major, $minor) = explode('_', $version);
            if ( $minor !== $laravelMinor || $major !== $laravelMajor ) {
                continue;
            }
            $this->directiveOverrides = $overrides;
        }
        return $this;
    }


    protected $resolvedDirectives = [];

    public function getResolvedDirective($name, $params = [])
    {
        if ( false === array_key_exists($name, $this->resolvedDirectives) ) {
            $handler = array_key_exists($name, $this->directiveOverrides) ? $this->directiveOverrides[ $name ] : $this->directives->get($name);

            if ( $handler instanceof \Closure ) {
                $this->resolvedDirectives[ $name ] = function ($value) use ($name, $handler, $params) {
                    return call_user_func_array($handler, $params);
                };
            } else {
                $class    = $this->isCallableWithAtSign($handler) ? explode('@', $handler)[ 0 ] : $handler;
                $method   = $this->isCallableWithAtSign($handler) ? explode('@', $handler)[ 1 ] : 'handle';
                $instance = $this->app->make($class);
                $instance->setName($name);
                $this->resolvedDirectives[ $name ] = function ($value) use ($name, $instance, $method, $params) {
                    return call_user_func_array([ $instance, $method ], $params);
                };
            }
        }

        return call_user_func_array($this->resolvedDirectives[ $name ], $params);
    }

    protected function isCallableWithAtSign($callback)
    {
        return is_string($callback) && strpos($callback, '@') !== false;
    }


}
