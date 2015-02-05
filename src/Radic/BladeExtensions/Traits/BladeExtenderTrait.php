<?php namespace Radic\BladeExtensions\Traits;

use Illuminate\Foundation\Application;

trait BladeExtenderTrait
{

    public $blacklist = [];

    public static function attach(Application $app)
    {
        $blade = $app['view']->getEngineResolver()->resolve('blade')->getCompiler();
        $class = new static;
        foreach (get_class_methods($class) as $method) {
            if ($method == 'attach') {
                continue;
            }
            if (is_array($class->blacklist) && in_array($method, $class->blacklist)) {
                continue;
            }

            $blade->extend(
                function ($value) use ($app, $class, $blade, $method) {
                    return $class->$method($value, $app, $blade);
                }
            );
        }
    }
}
