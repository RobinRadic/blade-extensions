<?php
/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 8/7/16
 * Time: 2:41 AM
 */
return [
    'mode'                => 'auto',
    'directives'          => [
        'set'   => 'Radic\\BladeExtensions\\Seven\\Directives\\SetDirective',
        'unset' => 'Radic\\BladeExtensions\\Seven\\Directives\\UnsetDirective',

        'breakpoint' => 'Radic\\BladeExtensions\\Seven\\Directives\\BreakpointDirective',
//        'debug'      => 'Radic\\BladeExtensions\\Seven\\Directives\\DebugDirective',
//        'dump'      => 'Radic\\BladeExtensions\\Seven\\Directives\\DumpDirective',

        'foreach'    => 'Radic\\BladeExtensions\\Seven\\Directives\\ForeachDirective',
        'endforeach' => 'Radic\\BladeExtensions\\Seven\\Directives\\EndforeachDirective',
        'break'      => 'Radic\\BladeExtensions\\Seven\\Directives\\BreakDirective',
        'continue'   => 'Radic\\BladeExtensions\\Seven\\Directives\\ContinueDirective',

        'macro'    => 'Radic\\BladeExtensions\\Seven\\Directives\\MacroDirective',
        'endmacro' => 'Radic\\BladeExtensions\\Seven\\Directives\\EndmacroDirective',
        'macrodef' => 'Radic\\BladeExtensions\\Seven\\Directives\\MacrodefDirective',

        'markdown'    => 'Radic\\BladeExtensions\\Seven\\Directives\\MarkdownDirective',
        'endmarkdown' => 'Radic\\BladeExtensions\\Seven\\Directives\\EndmarkdownDirective',

        'minify'    => 'Radic\\BladeExtensions\\Seven\\Directives\\MinifyDirective',
        'endminify' => 'Radic\\BladeExtensions\\Seven\\Directives\\EndminifyDirective',

        'embed' => 'Radic\\BladeExtensions\\Seven\\Directives\\EmbedDirective',

//        'spaceless' => 'Radic\\BladeExtensions\\Seven\\Directives\\SpacelessDirective',
//        'endspaceless' => 'Radic\\BladeExtensions\\Seven\\Directives\\EndspacelessDirective',
    ],
    'version_overrides'   => [
        '5_0' => [
            'breakpoint' => 'Radic\\BladeExtensions\\Seven\\Directives\\Breakpoint50Directive'
        ],
        '5_1' => [
            'breakpoint' => null // 'disabled' the directive
        ],
        '5_2' => [],
        '5_3' => [

            // 5.3 implemented a $loop
            'foreach'    => null,
            'endforeach' => null,
            'break'      => null,
            'continue'   => null,
        ]
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


