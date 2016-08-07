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
        'set'   => 'Radic\\BladeExtensions\\Seven\\Directives\\AssignmentDirectives@handleSet',
        'unset' => 'Radic\\BladeExtensions\\Seven\\Directives\\AssignmentDirectives@handleUnset',
//
//        'breakpoint' => 'Radic\\BladeExtensions\\Seven\\Directives\\DebugDirectives@breakpointDirective',
//        'debug'      => 'Radic\\BladeExtensions\\Seven\\Directives\\DebugDirectives@debugDirective',
//
//        'foreach'    => 'Radic\\BladeExtensions\\Seven\\Directives\\LoopDirectives@foreachDirective',
//        'endforeach' => 'Radic\\BladeExtensions\\Seven\\Directives\\LoopDirectives@endforeachDirective',
//        'break'      => 'Radic\\BladeExtensions\\Seven\\Directives\\LoopDirectives@breakDirective',
//        'continue'   => 'Radic\\BladeExtensions\\Seven\\Directives\\LoopDirectives@continueDirective',
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
