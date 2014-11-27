<?php

/*
 * This file is part of the Pinocchio library.
 *
 * (c) José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pinocchio\Logger;


/**
 * Logger Interface.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
interface LoggerInterface
{
    /**
     * Constructor.
     *
     * @param array|\Clinner\ValueHolder $options An optional set of options for the logger.
     */
    function __construct($options = array());

    /**
     * Log an info message.
     * This method should return this object for a fluent interface.
     *
     * @param  string $message The message to log.
     *
     * @return \Pinocchio\Logger\LoggerInterface
     */
    function log($message);

    /**
     * Log an error message.
     * This method should return this object for a fluent interface.
     *
     * @param  string $message The error message to log.
     *
     * @return \Pinocchio\Logger\LoggerInterface
     */
    function error($message);
}
