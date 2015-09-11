<?php
/**
 * Part of Radic - Blade Extensions
 *
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2015, Robin Radic - Radic Technologies
 * @link           http://radic.nl
 */

return array(
    /*
    |---------------------------------------------------------------------
    | Blacklisting of directives
    |---------------------------------------------------------------------
    |
    | These directives will be excluded.
    |
    */
    'blacklist' => array(),
    /*
    |---------------------------------------------------------------------
    | Markdown options
    |---------------------------------------------------------------------
    |
    */
    'markdown'  => array(
        /*
        |---------------------------------------------------------------------
        | Enable markdown directives
        |---------------------------------------------------------------------
        |
        */
        'enabled'  => true,
        /*
        |---------------------------------------------------------------------
        | Markdown renderer class
        |---------------------------------------------------------------------
        |
        | Class that renders markdown. Needs to implement Radic\BladeExtensions\Contracts\MarkdownRenderer
        |
        */
        'renderer' => 'Radic\BladeExtensions\Renderers\ParsedownRenderer',
        /*
        |---------------------------------------------------------------------
        | Enable view compiler
        |---------------------------------------------------------------------
        |
        | Enables markdown view compiler.
        | This will enable you to use View::make('my_markdown_file') on `my_markdown_file.md`.
        | Or use @include('my_markdown_file')
        |
        */
        'views'    => false
    ),
    /*
    |---------------------------------------------------------------------
    | Directives overrides
    |---------------------------------------------------------------------
    |
    | You can override any blade-extensions directive.
    | For reference see the directives.php file in the blade-extensions/src views
    */
    'overrides' => array(/*
        'macro' => array(
            'pattern' => '/(?<!\\w)(\\s*)@macro(?:\\s*)\\((?:\\s*)[\'"]([\\w\\d]*)[\'"],(.*)\\)/',
            'replacement' => '$1<?php if(array_key_exists("form", $__env->getContainer()->getBindings())){ echo app("form")->$2($3); } ?>'
        )
        */
    ),

);
