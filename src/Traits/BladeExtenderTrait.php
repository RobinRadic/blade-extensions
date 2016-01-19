<?php
/**
 * Adds an static function `attach` that if called, will instanciate and execute all functions as blade extends
 */
namespace Radic\BladeExtensions\Traits;

use Illuminate\Contracts\Foundation\Application;

/**
 * Adds an static function `attach` that if called, will instanciate and execute all functions as blade extends
 *
 * @package            Radic\BladeExtensions
 * @version            2.1.0
 * @author             Robin Radic
 * @license            MIT License - http://radic.mit-license.org
 * @copyright          2011-2015, Robin Radic
 * @link               http://robin.radic.nl/blade-extensions
 *
 */
trait BladeExtenderTrait
{

    /**
     * An array of methods that should be excluded by attach
     *
     * @var array
     */
    public $blacklist;

    /**
     * An array of methodName => directiveReplacement
     *
     * @var array
     */
    public $directives;

    public $directivesFile;

    public $overrides;

    /**
     * Instanciate and execute all functions as blade extends
     *
     * @param Application $app The current application
     */
    public static function attach(Application $app)
    {

        /** @var \Illuminate\View\Compilers\BladeCompiler $blade */
        $blade  = $app->make('view')->getEngineResolver()->resolve('blade')->getCompiler();
        $config = $app->make('config');
        $class  = new static;

        if (!isset($class->directivesFile)) {
            $class->directivesFile = __DIR__ . '/../directives.php';
        }

        $blacklist  = isset($class->blacklist) ? $class->blacklist : $config->get('blade_extensions.blacklist');
        $directives = isset($class->directives) ? $class->directives : $app->make('files')->getRequire($class->directivesFile);
        $overrides  = isset($class->overrides) ? $class->overrides : $config->get('blade_extensions.overrides', [ ]);

        foreach ($overrides as $method => $override) {
            if (! isset($directives[ $method ])) {
                continue;
            }
            if (isset($override[ 'pattern' ])) {
                $directives[ $method ][ 'pattern' ] = $override[ 'pattern' ];
            }
            if (isset($override[ 'replacement' ])) {
                $directives[ $method ][ 'replacement' ] = $override[ 'replacement' ];
            }
        }

        foreach ($directives as $name => $directive) {
            $method = 'directive' . ucfirst($name);
            if ((is_array($blacklist) && in_array($name, $blacklist, true)) || ! method_exists($class, $method)) {
                continue;
            }

            $blade->extend(function ($value) use ($class, $method, $directive, $app, $blade) {

                return $class->$method($value, $directive[ 'pattern' ], $directive[ 'replacement' ], $app, $blade);
            });
        }
    }


    /**
     * Get the regular expression for a generic Blade function.
     *
     * @param  string $function
     * @return string
     */
    public function createMatcher($function)
    {
        return '/(?<!\w)(\s*)@' . $function . '(\s*\(.*\))/';
    }

    /**
     * Get the regular expression for a generic Blade function.
     *
     * @param  string $function
     * @return string
     */
    public function createOpenMatcher($function)
    {
        return '/(?<!\w)(\s*)@' . $function . '(\s*\(.*)\)/';
    }

    /**
     * Create a plain Blade matcher.
     *
     * @param  string $function
     * @return string
     */
    public function createPlainMatcher($function)
    {
        return '/(?<!\w)(\s*)@' . $function . '(\s*)/';
    }
}
