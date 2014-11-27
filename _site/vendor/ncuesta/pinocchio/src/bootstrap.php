<?php

/*
 * This file is part of the Pinocchio library.
 *
 * (c) José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/**
 * This file is mainly Composer's bootstrap file, with some slight editions
 * to better suit Pinocchio's needs.
 *
 * @link https://github.com/composer/composer/blob/master/src/bootstrap.php
 */

/**
 * Require a file, only if it exists.
 * Return a boolean value indicating the result of the operation.
 *
 * @param  string $file The path to the file to require.
 *
 * @return bool
 */
function requireIfExists($file)
{
    if ($success = file_exists($file)) {
        require_once($file);
    }

    return $success;
}

if (!requireIfExists(__DIR__.'/../vendor/autoload.php') && !requireIfExists(__DIR__.'/../../../autoload.php')) {
    die('You must set up the project dependencies, run the following commands:'.PHP_EOL.
        'curl -s http://getcomposer.org/installer | php'.PHP_EOL.
        'php composer.phar install'.PHP_EOL);
}