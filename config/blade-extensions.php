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

return [
    'directives'        => [
        'set'   => 'Radic\\BladeExtensions\\Directives\\SetDirective',
        'unset' => 'Radic\\BladeExtensions\\Directives\\UnsetDirective',

        'breakpoint' => 'Radic\\BladeExtensions\\Directives\\BreakpointDirective',
        'dump'       => 'Radic\\BladeExtensions\\Directives\\DumpDirective',

        'foreach'    => 'Radic\\BladeExtensions\\Directives\\ForeachDirective',
        'endforeach' => 'Radic\\BladeExtensions\\Directives\\EndforeachDirective',
        'break'      => 'Radic\\BladeExtensions\\Directives\\BreakDirective',
        'continue'   => 'Radic\\BladeExtensions\\Directives\\ContinueDirective',

//        'closure' => function ($value) {
//            return $value;
//        },

    ],
    // `optional` directives are only used for **unit-testing**
    // If you want to use any of the `optional` directives, you have to **manually copy/paste** them to `directives`.
    'optional'          => [

        // If possible, use components instead: https://laravel.com/docs/5.6/blade#components-and-slots
        'embed' => 'Radic\\BladeExtensions\\Directives\\EmbedDirective',

        // If possible, use components instead: https://laravel.com/docs/5.6/blade#components-and-slots
        'macro'    => 'Radic\\BladeExtensions\\Directives\\MacroDirective',
        'endmacro' => 'Radic\\BladeExtensions\\Directives\\EndmacroDirective',
        'macrodef' => 'Radic\\BladeExtensions\\Directives\\MacrodefDirective',

        'markdown'    => 'Radic\\BladeExtensions\\Directives\\MarkdownDirective',
        'endmarkdown' => 'Radic\\BladeExtensions\\Directives\\EndmarkdownDirective',

        'minify'    => 'Radic\\BladeExtensions\\Directives\\MinifyDirective',
        'endminify' => 'Radic\\BladeExtensions\\Directives\\EndminifyDirective',

        'spaceless'    => 'Radic\\BladeExtensions\\Directives\\SpacelessDirective',
        'endspaceless' => 'Radic\\BladeExtensions\\Directives\\EndspacelessDirective',

        'ifsection'     => 'Radic\\BladeExtensions\\Directives\\IfSectionDirective',
        'elseifsection' => 'Radic\\BladeExtensions\\Directives\\ElseIfSectionDirective',
        'endifsection'  => 'Radic\\BladeExtensions\\Directives\\EndIfSectionDirective',
    ],
    'version_overrides' => [

        // 5.2 introduced @break and @continue
        // but blade-extensions's @foreach relies on them so we don't yet disable them
        // 5.3 introduced the loop variable for the @foreach directive. we can disable these.
        // NOTE: If you have used blade-extensions's @foreach before blade-extensions:7.0.0, you probably want to remove this
        // TL:DR: upgrading to blade-extension 7.0.0? then remove this
        '>=5.3' => [
            'break'      => null,
            'continue'   => null,
            'foreach'    => null,
            'endforeach' => null,
        ],
    ],
];
