#!/usr/bin/env php
<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright 2017 Robin Radic
 * @license   https://radic.mit-license.org MIT License
 * @version   7.0.0 Radic\BladeExtensions
 */
$content = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '.curl-output');
if ($content === false) {
    echo '3';
}
$content = json_decode($content, true);
$state   = $content[ 'build' ][ 'state' ];
if ($state === 'failed' || $state === 'canceled') {
    echo '1';
} elseif ($state === 'passed') {
    echo '0';
} else {
    echo '2';
}
