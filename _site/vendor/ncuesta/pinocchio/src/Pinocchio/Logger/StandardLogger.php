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
 * StandardLogger
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class StandardLogger implements LoggerInterface
{
    /**
     * Options for the logger.
     *
     * @var \Clinner\ValueHolder
     */
    private $options;

    private $stdout;

    private $stderr;

    /**
     * Constructor.
     *
     * @param array|\Clinner\ValueHolder $options An optional set of options for the logger.
     */
    public function __construct($options = array())
    {
        $this->options = new ValueHolder($options);

        $this->stdout = fopen('php://stdout', 'w+');
        $this->stderr = fopen('php://stderr', 'w+');
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
        fputs($this->stdout, $message);

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
        fputs($this->stderr, $message);

        return $this;
    }
}
