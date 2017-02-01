<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2017 (c) Robin Radic
 * @license https://radic.mit-license.org The MIT License
 */

return [
    'mode'              => 'auto',
    'directives'        => [
        'set'   => 'Radic\\BladeExtensions\\Directives\\SetDirective',
        'unset' => 'Radic\\BladeExtensions\\Directives\\UnsetDirective',

        'breakpoint' => 'Radic\\BladeExtensions\\Directives\\BreakpointDirective',
        'debug'      => 'Radic\\BladeExtensions\\Directives\\DebugDirective',
        'dump'       => 'Radic\\BladeExtensions\\Directives\\DebugDirective',

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

        'spaceless'    => 'Radic\\BladeExtensions\\Directives\\SpacelessDirective',
        'endspaceless' => 'Radic\\BladeExtensions\\Directives\\EndspacelessDirective',

        'embed' => 'Radic\\BladeExtensions\\Directives\\EmbedDirective',

        'closure' => function ($value) {
            return $value;
        },
//        'spaceless' => 'Radic\\BladeExtensions\\Directives\\SpacelessDirective',
//        'endspaceless' => 'Radic\\BladeExtensions\\Directives\\EndspacelessDirective',
    ],
    'version_overrides' => [
        '5.0' => [
        ],
        '5.1' => [
        ],
        // 5.2 introduced @break and @continue
        '5.2' => [
            'break'    => null,
            'continue' => null,
        ],
        // 5.3 introduced the loop variable for the @foreach directive.
        '5.3' => [
            'foreach'    => null,
            'endforeach' => null,
            'break'      => null,
            'continue'   => null,
        ],
    ],
];
