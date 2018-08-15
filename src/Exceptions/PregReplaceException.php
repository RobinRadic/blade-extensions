<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright 2017 Robin Radic
 * @license https://radic.mit-license.org MIT License
 *
 * @version 7.0.0 Radic\BladeExtensions
 */

namespace Radic\BladeExtensions\Exceptions;

use RuntimeException;

/**
 * {@inheritdoc}
 */
class PregReplaceException extends RuntimeException
{
    /**
     * error method.
     *
     * @param $error
     * @param $class
     *
     * @return static
     */
    public static function error($error, $class)
    {
        return new static("Class [{$class}] preg error [$error]");
    }
}
