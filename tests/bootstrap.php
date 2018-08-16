<?php

class_alias('PHPUnit\Framework\TestCase', 'PHPUnit_Framework_TestCase');

$up = DIRECTORY_SEPARATOR . '..';

$file = __DIR__ . $up . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

if ( ! file_exists($file)) {
    $file = __DIR__ . $up  . $up . $up . $up . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
}

require_once $file;

