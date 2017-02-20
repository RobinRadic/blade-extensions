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
    'directives'        => [
        'set'   => 'Radic\\BladeExtensions\\Directives\\SetDirective',
        'unset' => 'Radic\\BladeExtensions\\Directives\\UnsetDirective',

        'breakpoint' => 'Radic\\BladeExtensions\\Directives\\BreakpointDirective',
        'debug'      => 'Radic\\BladeExtensions\\Directives\\DebugDirective',
//        'dump'       => 'Radic\\BladeExtensions\\Directives\\DebugDirective',

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

//        'spaceless'    => 'Radic\\BladeExtensions\\Directives\\SpacelessDirective',
//        'endspaceless' => 'Radic\\BladeExtensions\\Directives\\EndspacelessDirective',

//        'closure' => function ($value) {
//            return $value;
//        },
    ],
    'version_overrides' => [

        // 5.2 introduced @break and @continue
        // but blade-extensions's @foreach relies on them so we don't yet disable them
        // 5.3 introduced the loop variable for the @foreach directive. we can disable these.
        // NOTE: If you have used blade-extensions's @foreach before blade-extensions:7.0.0, you probably
        // want to remove this
//        '>=5.3' => [
//            'break'    => null,
//            'continue' => null,
//            'foreach'    => null,
//            'endforeach' => null,
//        ]
    ],
];
