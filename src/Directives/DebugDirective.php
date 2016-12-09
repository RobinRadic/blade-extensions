<?php
namespace Radic\BladeExtensions\Directives;

class DebugDirective extends Directive
{
    protected $pattern = '/(?<!\w)(\s*)@NAME(\s*\(.*\))/';

    protected $replace = <<<'EOT'
    <?php
    if(class_exists('Kint')) {
        Kint::dump$2;
    } elseif(class_exists('Illuminate\Support\Debug\HtmlDumper')){
        \Illuminate\Support\Debug\HtmlDumper::dump($2);
    } else {
        echo '<pre><code>';
        var_dump($2);
        echo '</code></pre>';
    }
    ?>
EOT;


}
