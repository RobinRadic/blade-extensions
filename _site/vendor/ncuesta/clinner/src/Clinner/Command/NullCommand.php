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
 * NullCommand class.
 * This class represents a null command (Null Object pattern implementation).
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class NullCommand implements CommandInterface, PipingCommandInterface, PipeableCommandInterface
{
    /**
     * Run this command and get the exit code for it.
     *
     * @param string $input (Optional) input string for this command.
     *
     * @return \Clinner\Command\CommandInterface This command, for a fluent API.
     */
    public function run($input = null)
    {
        // Do nothing
        return $this;
    }

    /**
     * Get the exit code for this command's execution.
     * This method will only return a valid value after the command has been executed.
     *
     * @return int
     */
    public function getExitCode()
    {
        // Null commands are always successful, aren't they?
        return 0;
    }

    /**
     * Get the output for this command's execution.
     * This method will only return a valid value after the command has been executed.
     *
     * @return string
     */
    public function getOutput()
    {
        return '';
    }

    /**
     * Get a string representing this command.
     *
     * @return string
     */
    public function toCommandString()
    {
        return '';
    }

    /**
     * Get the command piped to this one, if any.
     *
     * @return \Clinner\Command\PipeableCommandInterface
     */
    public function getPipedCommand()
    {
        return null;
    }

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
    public function pipe(PipeableCommandInterface $anotherCommand, $appendToPipe = true)
    {
        // The trick here is to return $anotherCommand directly
        // instead of this command
        return $anotherCommand;
    }

    /**
     * Answer whether this command has a command piped to it.
     *
     * @return bool
     */
    public function hasPipedCommand()
    {
        return false;
    }

    /**
     * Get the output for this command's execution.
     * This method will only return a valid value after the command has been executed.
     *
     * @return string
     */
    public function getErrorOutput()
    {
        return '';
    }
}
