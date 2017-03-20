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

namespace Radic\BladeExtensions\Helpers;

/**
 * This is the class DumpHelper.
 *
 * @author  Robin Radic
 */
class DumpHelper
{
    /** @var array */
    protected $dumpers = [];

    /** @var \Closure */
    protected $dumper;

    /** @var \Illuminate\View\Factory */
    protected $env;

    /** @var array */
    protected $vars;

    /** @var  string */
    protected $path;

    /**
     * DumpHelper constructor.
     *
     * @param array $dumpers
     */
    public function __construct()
    {
        $this->setDefaultDumpers();
    }

    /**
     * setEnv method.
     *
     * @param \Illuminate\View\Factory $env
     * @param array                    $vars
     *
     * @param null|string              $path
     *
     * @return $this
     */
    public function setEnvData($env, $vars, $path = null)
    {
        $this->env = $env;
        $this->vars = $vars;
        $this->path = $path;

        return $this;
    }

    /**
     * dump method.
     *
     * @param mixed ...$vars
     *
     * @return \Radic\BladeExtensions\Helpers\DumpHelper
     */
    public function dump($vars = null)
    {
        $dumper = $this->resolveDumper();

        if (null === $vars) {
            $dumper([
                'path'      => $this->path === null ? 'null' : $this->path,
                'env'       => $this->env,
                'variables' => $this->vars,
            ]);
        } else {
            foreach (func_get_args() as $var) {
                $dumper($var);
            }
        }

        return $this;
    }

    /**
     * resolveDumper method.
     *
     * @return \Closure
     */
    protected function resolveDumper()
    {
        if (null === $this->dumper) {
            foreach ($this->dumpers as $dumper) {
                if (call_user_func($dumper[ 0 ]) === true) {
                    $this->dumper = $dumper[ 1 ];
                    break;
                }
            }
        }

        return $this->dumper;
    }

    /**
     * setDefaultDumpers method.
     *
     * @return void
     */
    protected function setDefaultDumpers()
    {
        $this->dumpers = [
            [
                function () {
                    return class_exists('Kint');
                },
                function ($var) {
                    \Kint::dump($var);
                },
            ],
            [
                function () {
                    return class_exists('Illuminate\Support\Debug\Dumper');
                },
                function ($var) {
                    (new \Illuminate\Support\Debug\Dumper)->dump($var);
                },
            ],
            [
                function () {
                    return class_exists('Symfony\Component\VarDumper\VarDumper');
                },
                function ($var) {
                    \Symfony\Component\VarDumper\VarDumper::dump($var);
                },
            ],
            [
                function () {
                    return true;
                },
                function ($var) {
                    echo '<pre><code>';
                    var_dump($var);
                    echo '</code></pre>';
                },
            ],
        ];
    }

    /**
     * @return array
     */
    public function getDumpers()
    {
        return $this->dumpers;
    }

    /**
     * Set the dumpers value.
     *
     * @param array $dumpers
     *
     * @return DumpHelper
     */
    public function setDumpers($dumpers)
    {
        $this->dumpers = $dumpers;

        return $this;
    }

    /**
     * Set the env value.
     *
     * @param \Illuminate\View\Factory $env
     *
     * @return DumpHelper
     */
    public function setEnv($env)
    {
        $this->env = $env;

        return $this;
    }

    /**
     * Set the vars value.
     *
     * @param array $vars
     *
     * @return DumpHelper
     */
    public function setVars($vars)
    {
        $this->vars = $vars;

        return $this;
    }

    /**
     * Set the path value.
     *
     * @param null|string $path
     *
     * @return DumpHelper
     */
    public function setPath($path = null)
    {
        $this->path = $path;

        return $this;
    }
}
