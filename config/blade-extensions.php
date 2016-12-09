<?php
return [
    'mode'                => 'auto',
    'directives'          => [
        'set'   => 'Radic\\BladeExtensions\\Directives\\SetDirective',
        'unset' => 'Radic\\BladeExtensions\\Directives\\UnsetDirective',

        'breakpoint' => 'Radic\\BladeExtensions\\Directives\\BreakpointDirective',
//        'debug'      => 'Radic\\BladeExtensions\\Directives\\DebugDirective',
//        'dump'      => 'Radic\\BladeExtensions\\Directives\\DumpDirective',

        'foreach'    => 'Radic\\BladeExtensions\\Directives\\ForeachDirective',
        'endforeach' => 'Radic\\BladeExtensions\\Directives\\EndforeachDirective',
        'break'      => 'Radic\\BladeExtensions\\Directives\\BreakDirective',
        'continue'   => 'Radic\\BladeExtensions\\Directives\\ContinueDirective',

        'macro'    => 'Radic\\BladeExtensions\\Directives\\MacroDirective',
        'endmacro' => 'Radic\\BladeExtensions\\Directives\\EndmacroDirective',
        'macrodef' => 'Radic\\BladeExtensions\\Directives\\MacrodefDirective',

        'markdown'    => 'Radic\\BladeExtensions\\Directives\\MarkdownDirective',
        'endmarkdown' => 'Radic\\BladeExtensions\\Directives\\EndmarkdownDirective',

        'minify'    => 'Radic\\BladeExtensions\\Directives\\MinifyDirective',
        'endminify' => 'Radic\\BladeExtensions\\Directives\\EndminifyDirective',

        'embed' => 'Radic\\BladeExtensions\\Directives\\EmbedDirective',

//        'spaceless' => 'Radic\\BladeExtensions\\Directives\\SpacelessDirective',
//        'endspaceless' => 'Radic\\BladeExtensions\\Directives\\EndspacelessDirective',
    ],
    'version_overrides'   => [
        '5.0' => [
            'breakpoint' => 'Radic\\BladeExtensions\\Directives\\Breakpoint50Directive'
        ],
        '5.1' => [
            'breakpoint' => null // 'disabled' the directive
        ],
        '5.2' => [],
        '5.3' => []
    ],
    'disabled_directives' => [
        'debug',
    ],
    'overrides'           => [
        'debug' => [
            'pattern'     => '',
            'replacement' => '',
        ],
    ],
];
