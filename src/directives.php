<?php

return [

    // AssignmentDirectives
    'set'        => [    // https://regex101.com/r/uD8bI1/1
        'pattern'     => '/(?<!\w)(\s*)@set\s*\(\s*\${0,1}[\'"\s]*(.*?)[\'"\s]*,\s*([\W\w^]*?)\)\s*$/m',
        'replacement' => <<<'EOT'
$1<?php \$$2 = $3; $__data['$2'] = $3; ?>
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
    <?php
    if(class_exists('Kint')) {
        Kint::dump($2);
    } elseif(class_exists('Illuminate\Support\Debug\HtmlDumper')){
        \Illuminate\Support\Debug\HtmlDumper::dump($2);
    } else {
        var_dump($2);
    }
    ?>
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
        'pattern' => '/(?<!\\w)(\\s*)@embed\\s*\\((.*?)\\)\\s*$((?>(?!@(?:end)?embed).|(?0))*)@endembed/sm',
        'replacement' => <<<'EOT'
$1<?php app('blade.helpers')->get('embed')->start($2); ?>
$1<?php app('blade.helpers')->get('embed')->current()->setData(\$__data)->setContent(<<<'EOT_'
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
    'macro'       => [
        'pattern'     => '/(?<!\\w)(\\s*)@macro(?:\\s*)\\((?:\\s*)[\'"]([\\w\\d]*)[\'"](?:,|)(.*)\\)/',
        'replacement' => <<<'EOT'
$1<?php echo app("blade.helpers")->$2($3); ?>
EOT
    ],
    'macrodef'     => [
        'pattern'     => '/(?<!\w)(\s*)@macrodef(?:\s*)\((?:\s*)[\'"]([\w\d]*)[\'"](?:,|)(.*)\)/',
        'replacement' => <<<'EOT'
$1<?php app("blade.helpers")->macro("$2", function($3){ ?>
EOT
    ],
    'endmacro'    => [
        'pattern'     => '/(?<!\\w)(\\s*)@endmacro(\\s*)/',
        'replacement' => <<<'EOT'
$1<?php }); ?>$2
EOT
    ],

    // MarkdownDirectives
    'markdown'  => [
        'pattern'     => '/(?<!\\w)(\\s*)@markdown(?!\\()(\\s*)/',
        'replacement' => <<<'EOT'
$1<?php echo app("blade.helpers")->get('markdown')->parse(<<<'EOT'$2
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
$1<?php echo app("blade.helpers")->get('minifier')->open$2; ?>
EOT

    ],
    'endminify'   => [
        'pattern'     => '/(?<!\\w)(\\s*)@endminify(\\s*)/',
        'replacement' => <<<'EOT'
$1<?php echo app("blade.helpers")->get('minifier')->close(); ?>
EOT
    ],


];
