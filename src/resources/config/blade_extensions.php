<?php
/**
 * Part of Radic - Blade Extensions
 *
 * @author     Robin Radic
 * @license    MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2015, Robin Radic - Radic Technologies
 * @link       http://radic.nl
 */

return array(
    /*
     * Blacklisting of directives. These directives will not be extended. Example:
     *
     * 'blacklist' => array('foreach', 'set', 'debug')
     */
    'blacklist' => array(),

    'markdown' => array(
        /*
         * Enable markdown directives
         */
        'enabled' => true,

        /*
         * Class that renders markdown. Needs to implement Radic\BladeExtensions\Contracts\MarkdownRenderer
         */
        'renderer' => 'Radic\BladeExtensions\Renderers\ParsedownRenderer',

        /*
         * Enable markdown view compiler.
         * This will enable you to use View::make('my_markdown_file') on `my_markdown_file.md`.
         */
        'views' => false
    ),
    /*
     * The replacement code for each directive.
     * Provides the ability to easily adjust helper classes and view execution logic
     */
    'directives' => array(
        // MacroDirective
        'doMacro' => <<<'EOT'
$1<?php
if(array_key_exists("form", $__env->getContainer()->getBindings())){
    echo app("form")->$2($3);
} ?>
EOT
    ,'openMacro' => <<<'EOT'
$1<?php
if(array_key_exists("form", $__env->getContainer()->getBindings())){
    app("form")->macro("$2", function($3){
EOT
    ,'closeMacro' => <<<'EOT'
    });
} ?>
EOT
        // ForEachDirective
    ,'openForeach' => <<<'EOT'
$1<?php
\Radic\BladeExtensions\Helpers\LoopFactory::newLoop($2);
foreach($2 as $3):
    $loop = \Radic\BladeExtensions\Helpers\LoopFactory::loop();
?>
EOT
    ,'closeForeach' => <<<'EOT'
$1<?php
\Radic\BladeExtensions\Helpers\LoopFactory::looped();
endforeach;
\Radic\BladeExtensions\Helpers\LoopFactory::endLoop($loop);
?>$2
EOT
    ,'addBreak' => <<<'EOT'
$1<?php
    break;
?>$2
EOT
    ,'addContinue' => <<<'EOT'
$1<?php
\Radic\BladeExtensions\Helpers\LoopFactory::looped();
continue;
?>$2
EOT
        // PartialDirective
    ,'addPartial' => <<<'EOT'
$1<?php \Radic\BladeExtensions\Helpers\Partial::renderPartial$2,
get_defined_vars(), function($file, $vars) use ($__env) {
        $vars = array_except($vars, array('__data', '__path'));
        extract($vars); ?>
EOT
    ,'endPartial' => <<<'EOT'
$1<?php echo $__env->make($file, $vars)->render(); }); ?>$2
EOT
    ,'openBlock' => <<<'EOT'
$1<?php \Radic\BladeExtensions\Helpers\Partial::startBlock$2; ?>
EOT
    ,'endBlock' => <<<'EOT'
$1<?php \Radic\BladeExtensions\Helpers\Partial::stopBlock(); ?>$2
EOT
    ,'addRender' => <<<'EOT'
$1<?php echo \Radic\BladeExtensions\Helpers\Partial::renderBlock$2; ?>
EOT
        // AssignmentDirective
    ,'addSet' => <<<'EOT'
$1<?php \$$2 = $3; ?>
EOT
    ,'addUnset' => <<<'EOT'
$1<?php unset(\$$2); ?>
EOT
        // DebugDirectives
    ,'addDebug' => <<<'EOT'
$1<h1>DEBUG OUTPUT:</h1>
<pre><code>
    <?php (class_exists('Kint') ? Kint::dump($2) : var_dump($2)) ?>
</code></pre>
EOT
    ,'addBreakpoint' => <<<'EOT'
<!-- breakpoint --><?php
if(function_exists('xdebug_break')){
    var_dump(xdebug_break());
}
?>
EOT
        // MarkdownDirectives
    ,'openMarkdown' => <<<'EOT'
$1<?php echo \Radic\BladeExtensions\Helpers\Markdown::parse(<<<'EOT'$2
EOT
    ,'closeMarkdown' => "$1\nEOT\n); ?>$2"
        // WidgetDirectives
    ,'openWidget' => <<<'EOT'
$1<?php app('blade.widgets')->openWidget$2; ?>
EOT
    ,'closeWidget' => <<<'EOT'
$1<?php app('blade.widgets')->closeWidget(); ?>
EOT
    ,'startWidgetBlock' => <<<'EOT'
$1<?php app('blade.widgets')->getCurrentWidget()->startSection$2 ?>
EOT
    ,'stopWidgetBlock' => <<<'EOT'
$1<?php app('blade.widgets')->getCurrentWidget()->stopSection$2 ?>
EOT
    ,'renderWidgetBlock' => <<<'EOT'
$1<?php $__widget->yieldSection$2 ?>
EOT
    )
);
