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


/*
 * reads travis build JSON
 * checks:                      > returns:
 * ---------------------------------------
 * all other jobs passed?       > pass
 * any job failed?              > fail
 * any error?                   > error
 * still working?               > wait
 */

function ex($msg)
{
    echo $msg;
    exit(0);
}

$content = file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . '.curl-output');
if ($content === false) {
    ex('error');
}
$content = json_decode($content, true);

$state = $content[ 'build' ][ 'state' ];
if ($state === 'failed' || $state === 'canceled') {
    ex('fail');
}

$total  = count($content[ 'jobs' ]);
$passed = 0;
foreach ($content[ 'jobs' ] as $job) {
    $state = $job[ 'state' ];
    if ($state === 'failed' || $state === 'canceled') {
        ex('fail');
        exit(0);
    } elseif ($state === 'passed') {
        $passed++;
    }
}

// -1 : there will be 1 job doing this script that is started and not finished
if ($passed < ($total -1)) {
    ex('wait');
} elseif ($passed === ($total -1)) {
    ex('pass');
} else {
    ex('error');
}
