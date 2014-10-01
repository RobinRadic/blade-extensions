<?php namespace Radic\BladeExtensions\Core; /**
 * Part of the RadiCMS packges.
 *
 * NOTICE OF LICENSE
 *
 * Licensed under the RadiCMS Propietary License.
 *
 * This source file is subject to the RadiCMS Propietary License that is
 * bundled with this package in the LICENSE.html file.
 *
 * @package    radicms
 * @version    1.0.0
 * @author     Radic Technologies
 * @license    Propietary
 * @copyright  (c) 2011-2014, Radic Technologies
 * @link       http://radic.nl
 */
use Illuminate\Foundation\Application;
use Illuminate\View\Compilers\Compiler;

/**
 * BladeExtender
 *
 * @package Radic\BladeExtensions\Core${NAME}
 */
class BladeExtender
{

    /**
     * @var \Illuminate\View\Compilers\BladeCompiler
     */
    protected $compiler;

    public static function attach(Application $app)
    {
        $blacklist = $app->config['radic/blade-extensions::blacklist'];
        $compiler = $app['view']->getEngineResolver()->resolve('blade')->getCompiler();
        $class = new static($compiler, $blacklist);
    }

    public function __construct(Compiler $compiler, array $blacklist = array())
    {
        $this->compiler = $compiler;
        foreach(get_class_methods($this) as $method)
        {
            if($method == 'attach') continue;
            if(is_array($blacklist) && in_array($method, $blacklist)) continue;

            $this->compiler->extend(function($value) use ($app, $class, $blade, $method)
            {
                return $class->$method($value, $app, $blade);
            });
        }

        return $class;
    }

} 