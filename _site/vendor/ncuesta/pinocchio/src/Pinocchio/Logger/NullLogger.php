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

use \Clinner\ValueHolder;


/**
 * NullLogger
 *
 * Null object pattern implementation for Loggers.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class NullLogger implements LoggerInterface
{
    /**
     * Constructor.
     *
     * @param array|\Clinner\ValueHolder $options An optional set of options for the logger.
     */
    public function __construct($options = array())
    {
    }

    /**
     * Log an info message.
     *
     * @param  string $message The message to log.
     *
     * @return \Pinocchio\Logger\LoggerInterface
     */
    public function log($message)
    {
        return $this;
    }

    /**
     * Log an error message.
     *
     * @param  string $message The error message to log.
     *
     * @return \Pinocchio\Logger\LoggerInterface
     */
    public function error($message)
    {
        return $this;
    }
}
