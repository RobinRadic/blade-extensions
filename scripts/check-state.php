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


function run()
{
    $content = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '.curl-output');
    if ($content === false) {
        return 3;
    }
    $content = json_decode($content, true);
    $state   = $content[ 'build' ][ 'state' ];
    if ($state === 'failed' || $state === 'canceled') {
        return 1;
    } elseif ($state === 'passed') {
        return 0;
    } else {
        return 2;
    }
}

echo run();
