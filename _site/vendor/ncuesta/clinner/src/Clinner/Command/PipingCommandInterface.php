<?php

/*
 * This file is part of the Clinner library.
 *
 * (c) José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clinner\Command;


/**
 * PipingCommandInterface
 * Interface to be implemented by Command classes that allow piping
 * other commands.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
interface PipingCommandInterface
{
    const PIPE = '|';

    /**
     * Get the command piped to this one, if any.
     *
     * @return \Clinner\Command\PipeableCommandInterface
     */
    public function getPipedCommand();

    /**
     * Pipe $anotherCommand to this one, so that this command's output is directly
     * sent to $anotherCommand's standard input.
     *
     * @param  \Clinner\Command\PipeableCommandInterface $anotherCommand The command to pipe.
     * @param  bool                                      $appendToPipe   Whether $anotherCommand will be appended to
     *                                                                   the currently piped commands (TRUE) or if it
     *                                                                   will be added after this command, rearranging
     *                                                                   the commands pipe to include it.
     *
     * @return \Clinner\Command\PipingCommandInterface This instance, for a fluent API.
     */
    public function pipe(PipeableCommandInterface $anotherCommand, $appendToPipe = true);

    /**
     * Answer whether this command has a command piped to it.
     *
     * @return bool
     */
    public function hasPipedCommand();
}
