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
 * Callback class.
 * This is a command abstraction which actually delegates the execution logic
 * to a callback function.
 * The function will be invoked with an input string argument, and is expected
 * to return an integer value representing the exit code for the command:
 *
 * <code>
 *  // @param  string|null $input The input for the string.
 *  // @return int The exit code for the command.
 * function callback(string $input);
 * </code>
 *
 * Any output generated to stdout will be buffered as the command's output.
 *
 * Usage examples:
 *
 * <code>
 *     // Get all the users in the system whose username contains at least one 'a'
 *     $systemUsers = Command::create('cat', array('/etc/passwd'))
 *         ->pipe(
 *             Command::create('grep', array('-v' => '^#'), array('delimiter' => ' '))
 *         )
 *         ->pipe(
 *             Command::create('cut', array('-d' => ':', '-f' => 1), array('delimiter' => ''))
 *         )
 *         ->pipe($callbackCommand)
 *         ->run()
 *         ->getOutputAsArray("\n");
 * </code>
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class Callback implements CommandInterface, PipingCommandInterface, PipeableCommandInterface
{
    /**
     * A command piped to this one, if any.
     *
     * @var \Clinner\Command\PipeableCommandInterface
     */
    private $_next;

    /**
     * Exit code for this command.
     *
     * @var int
     */
    private $_exitCode;

    /**
     * Output for this command.
     *
     * @var string
     */
    private $_output;

    /**
     * Error output for this command.
     *
     * @var string
     */
    private $_errorOutput;

    /**
     * Callback function/method that will be invoked when command is run.
     *
     * @var \Closure
     */
    private $_callback;

    /**
     * Constructor.
     *
     * @param \Closure $callback The callback function.
     */
    public function __construct($callback)
    {
        $this->setCallback($callback);
    }

    /**
     * Get the callback function for this command.
     *
     * @return \Closure
     */
    public function getCallback()
    {
        return $this->_callback;
    }

    /**
     * Set the callback function for this command.
     *
     * @param  \Closure $callback The callback function.
     *
     * @return \Clinner\Command\Callback This instance, for a fluent API.
     */
    public function setCallback($callback)
    {
        $this->_callback = $callback;
    }

    /**
     * Get the command piped to this one, if any.
     *
     * @return \Clinner\Command\PipeableCommandInterface
     */
    public function getPipedCommand()
    {
        return $this->_next;
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
        if (!$anotherCommand instanceof NullCommand) {
            if ($this === $anotherCommand) {
                // Cannot pipe a command to itself, need to clone it
                $anotherCommand = clone $anotherCommand;
            }

            if ($appendToPipe) {
                if ($this->hasPipedCommand()) {
                    $this->_next->pipe($anotherCommand, true);
                } else {
                    $this->_next = $anotherCommand;
                }
            } else {
                if ($this->hasPipedCommand()) {
                    // Rearrange the commands pipe
                    $anotherCommand->pipe($this->_next, false);
                }

                $this->_next = $anotherCommand;
            }
        }

        return $this;
    }

    /**
     * Answer whether this command has a command piped to it.
     *
     * @return bool
     */
    public function hasPipedCommand()
    {
        return null !== $this->_next;
    }

    /**
     * Run this command and get the exit code for it.
     *
     * @param string $input (Optional) input string for this command.
     *
     * @return \Clinner\Command\CommandInterface This command, for a fluent API.
     */
    public function run($input = null)
    {
        $callback = $this->getCallback();

        ob_start();

        $exitCode = $callback($input);

        $output = ob_get_contents();

        ob_end_clean();

        // Run the piped command, if any
        if ($this->hasPipedCommand()) {
            $pipedCommand = $this->getPipedCommand();

            $pipedCommand->run($output);

            $output      = $pipedCommand->getOutput();
            $exitCode    = $pipedCommand->getExitCode();
            $errorOutput = $pipedCommand->getErrorOutput();
        }

        $this->_output = $output;
        $this->_exitCode = $exitCode;

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
        return $this->_exitCode;
    }

    /**
     * Get the output for this command's execution.
     * This method will only return a valid value after the command has been executed.
     *
     * @return string
     */
    public function getOutput()
    {
        return $this->_output;
    }

    /**
     * Get the output for this command's execution.
     * This method will only return a valid value after the command has been executed.
     *
     * @return string
     */
    public function getErrorOutput()
    {
        return $this->_errorOutput;
    }

    /**
     * Get the code of the inner callback as string.
     *
     * @return string
     */
    public function getCallbackCode()
    {
        $reflection = new \ReflectionFunction($this->_callback);
        
        // Open file and seek to the first line of the closure
        $file = new \SplFileObject($reflection->getFileName());
        $file->seek($reflection->getStartLine() - 1);

        // Retrieve all of the lines that contain code for the closure
        $code = '';
        while ($file->key() < $reflection->getEndLine())
        {
            $code .= $file->current();
            $file->next();
        }

        $begin = strpos($code, 'function');
        $end = strrpos($code, '}');
        $code = substr($code, $begin, $end - $begin + 1);

        return $code;
    }
    
    /**
     * Get a string representation of this command with its arguments,
     * as if it would be written in a command-line interface when run.
     *
     * @return string
     */
    public function toCommandString()
    {
        return $this->getCallbackCode();
    }
}