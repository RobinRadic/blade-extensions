<?php

return [

    // AssignmentDirectives
    'set'        => [
        'pattern'     => '/(?<!\w)(\s*)@set(?:\s*)\((?:\s*)(?:\$|(?:\'|\"|))(.*?)(?:\'|\"|),(?:\s|)(.*)\)/',
        'replacement' => <<<'EOT'
$1<?php \$$2 = $3; ?>
EOT
    ],
    'unset'      => [
        'pattern'     => '/(?<!\\w)(\\s*)@unset(?:\\s*)\\((?:\\s*)(?:\\$|(?:\'|\\"|))(.*?)(?:\'|\\"|)(?:\\s*)\\)/',
        'replacement' => <<<'EOT'
$1<?php unset(\$$2); ?>
EOT
    ],

    // DebugDirectives
    'debug'      => [
        'pattern'     => '/(?<!\\w)(\\s*)@debug(?:\\s*)\\((?:\\s*)([^()]+)*\\)/',
        'replacement' => <<<'EOT'
$1<h1>DEBUG OUTPUT:</h1>
<pre><code>
    <?php (class_exists('Kint') ? Kint::dump($2) : var_dump($2)) ?>
</code></pre>
EOT
    ],
    'breakpoint' => [
        'pattern'     => '/(?<!\\w)(\\s*)@breakpoint(\\s*)/',
        'replacement' => <<<'EOT'
<!-- breakpoint --><?php
if(function_exists('xdebug_break')){
    var_dump(xdebug_break());
}
?>
EOT
    ],

    // EmbeddingDirectives
    'embed' => [
        'pattern' => '/(?<!\\w)(\\s*)@embed\\s*\\((.*?)\\)$((?>(?!@(?:end)?embed).|(?0))*)@endembed/sm',
        'replacement' => <<<'EOT'
$1<?php app('blade.helpers')->get('embed')->start($2)->setData($__data); ?>
$1<?php app('blade.helpers')->get('embed')->current()->setContent(<<<'EOT_'
$3
\EOT_
); ?>
$1<?php app('blade.helpers')->get('embed')->end(); ?>
EOT
    ],

    // ForeachDirectives
    'foreach'   => [
        'pattern'     => '/(?<!\\w)(\\s*)@foreach(?:\\s*)\\((.*)(?:\\sas)(.*)\\)/',
        'replacement' => <<<'EOT'
$1<?php
app('blade.helpers')->get('loop')->newLoop($2);
foreach($2 as $3):
    $loop = app('blade.helpers')->get('loop')->loop();
?>
EOT
    ],
    'endforeach'  => [
        'pattern'     => '/(?<!\\w)(\\s*)@endforeach(\\s*)/',
        'replacement' => <<<'EOT'
$1<?php
app('blade.helpers')->get('loop')->looped();
endforeach;
app('blade.helpers')->get('loop')->endLoop($loop);
?>$2
EOT
    ],
    'break'      => [
        'pattern'     => '/(?<!\\w)(\\s*)@break(\\s*)/',
        'replacement' => <<<'EOT'
$1<?php
    break;
?>$2
EOT
    ],
    'continue'   => [
        'pattern'     => '/(?<!\\w)(\\s*)@continue(\\s*)/',
        'replacement' => <<<'EOT'
$1<?php
app('blade.helpers')->get('loop')->looped();
continue;
?>$2
EOT
    ],

    // MacroDirectives
    'domacro'       => [
        'pattern'     => '/(?<!\\w)(\\s*)@domacro(?:\\s*)\\((?:\\s*)[\'"]([\\w\\d]*)[\'"],(.*)\\)/',
        'replacement' => <<<'EOT'
$1<?php
if(array_key_exists("form", $__env->getContainer()->getBindings())){
    echo app("form")->$2($3);
} ?>
EOT
    ],
    'macro'     => [
        'pattern'     => '/(?<!\\w)(\\s*)@macro(?:\\s*)\\((?:\\s*)[\'"]([\\w\\d]*)[\'"],(.*)\\)/',
        'replacement' => <<<'EOT'
$1<?php
if(array_key_exists("form", $__env->getContainer()->getBindings())){
    app("form")->macro("$2", function($3){
EOT
    ],
    'endmacro'    => [
        'pattern'     => '/(?<!\\w)(\\s*)@endmacro(\\s*)/',
        'replacement' => <<<'EOT'
    });
} ?>
EOT
    ],

    // MarkdownDirectives
    'markdown'  => [
        'pattern'     => '/(?<!\\w)(\\s*)@markdown(?!\\()(\\s*)/',
        'replacement' => <<<'EOT'
$1<?php echo \Radic\BladeExtensions\Helpers\Markdown::parse(<<<'EOT'$2
EOT
    ],
    'endmarkdown' => [
        'pattern'     => '/(?<!\\w)(\\s*)@endmarkdown(\\s*)/',
        'replacement' => "$1\nEOT\n); ?>$2"

    ],

    // MinifyDirectives
    'minify'    => [
        'pattern'     => '/(?<!\\w)(\\s*)@minify(\\s*\\(.*\\))/',
        'replacement' => <<<'EOT'
$1<?php echo \Radic\BladeExtensions\Helpers\Minifier::open$2; ?>
EOT

    ],
    'endminify'   => [
        'pattern'     => '/(?<!\\w)(\\s*)@endminify(\\s*)/',
        'replacement' => <<<'EOT'
$1<?php echo \Radic\BladeExtensions\Helpers\Minifier::close(); ?>
EOT
    ],


];
