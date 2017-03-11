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

namespace Radic\BladeExtensions\Directives;

/**
 * This is the class DebugDirective.
 *
 * @author  Robin Radic
 */
class DebugDirective extends Directive
{
    protected $replace = <<<'EOT'
    $1<?php
    if(class_exists('Kint')) {
        Kint::dump$2;
    } elseif(class_exists('Illuminate\Support\Debug\HtmlDumper')){
        \Illuminate\Support\Debug\HtmlDumper::dump($2);
    } else {
        echo '<pre><code>';
        var_dump($2);
        echo '</code></pre>';
    }
    ?>$2
EOT;
}
