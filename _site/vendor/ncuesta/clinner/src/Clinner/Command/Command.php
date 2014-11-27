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

use Clinner\ValueHolder;


/**
 * Command class.
 * Command abstraction class that allows running any command with a given set of arguments.
 *
 * Usage examples:
 *
 *     // Run `ls -l -a` in the current directory
 *     $command = new \Clinner\Command\Command(
 *         'ls',
 *         array('-l', '-a')
 *     );
 *     $command->run();
 *     echo $command->getExitCode();
 *     echo $command->getOutput();
 *
 *     // This example is equivalent to the one above
 *     $command = \Clinner\Command\Command::create(
 *         'ls',
 *         array('-l', '-a')
 *     )
 *     ->run();
 *     echo $command->getExitCode();
 *     echo $command->getOutput();
 *
 * You can also pipe commands, just like in a command-line interface:
 *
 *     use \Clinner\Command\Command;
 *
 *     $grepCommand = Command::create(
 *         'grep',
 *         array('-v' => '^#'),
 *         array('delimiter' => ' ')
 *     );
 *     $cutCommand  = Command::create(
 *         'cut',
 *         array('-d' => ':', '-f' => 1),
 *         array('delimiter' => '')
 *     );
 *     $systemUsers = Command::create(
 *         'cat',
 *         array('/etc/passwd')
 *     )
 *     ->pipe(
 *         $grepCommand->pipe(
 *             $cutCommand
 *         )
 *     )
 *     ->run()
 *     ->getOutputAsArray("\n");
 *
 * This class may take the following options:
 *
 *   * `delimiter` (`string`): A string that will be put in key-value pairs of arguments to separate the key
 *                             from its value. Defaults to '='.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class Command implements CommandInterface, PipingCommandInterface, PipeableCommandInterface
{
    const DEFAULT_DELIMITER = '=';

    /**
     * The name of the command.
     *
     * @var string
     */
    private $_name;

    /**
     * Arguments supplied for this command.
     *
     * @var \Clinner\ValueHolder
     */
    private $_arguments;

    /**
     * Options supplied for this command.
     *
     * @var \Clinner\ValueHolder
     */
    private $_options;

    /**
     * A command piped to this one, if any.
     *
     * @var \Clinner\Command\PipeableCommandInterface
     */
    private $_next;

    /**
     * Exit code for this command.
     * This value will only be set after it has been run.
     *
     * @var int
     */
    private $_exitCode;

    /**
     * Output for this command.
     * This value will only be set after it has been run.
     *
     * @var string
     */
    private $_output;

    /**
     * Error output for this command.
     * This value will only be set after it has been run.
     *
     * @var string
     */
    private $_errorOutput;

    /**
     * Factory method for creating new Commands and allowing to take advantage of the
     * fluent API provided by this class.
     *
     * @param string                     $name      The name of the command.
     * @param array|\Clinner\ValueHolder $arguments (Optional) arguments for the command.
     * @param array|\Clinner\ValueHolder $options   (Optional) options for the command.
     *
     * @return \Clinner\Command\Command
     */
    static public function create($name, $arguments = array(), $options = array())
    {
        return new static($name, $arguments, $options);
    }

    /**
     * Factory method for creating new Commands from their string representation,
     * as if they were being run from the command line. If no valid commands are
     * found, a NullCommand will be returned.
     * For example:
     * <code>
     *      $command = Command::fromString('cat /etc/hosts | grep localhost');
     * </code>
     * Is roughly equivalent to:
     * <code>
     *      $command = Command::create('cat', array('/etc/hosts'))
     *          ->pipe(Command::create('grep', array('localhost')));
     * </code>
     *
     * @param  string $commandString The command string to parse.
     *
     * @return \Clinner\Command\CommandInterface
     */
    static public function fromString($commandString)
    {
        $splitCommands = array_map(
            function($str) { return trim($str); },
            explode(self::PIPE, $commandString)
        );

        $command = new NullCommand();

        foreach ($splitCommands as $rawCommand) {
            $command = $command->pipe(static::parse($rawCommand));
        }

        return $command;
    }

    /**
     * Parse a command from a string representation and return the resulting
     * object.
     * If no valid command is found, a NullCommand will be returned.
     *
     * @param string $commandString The command string to parse.
     * @param array  $options       (Optional) options for the command.
     *
     * @return \Clinner\Command\CommandInterface
     */
    static protected function parse($commandString, $options = array())
    {
        $members = array_filter(explode(' ', $commandString));

        if (!empty($members)) {
            $commandName = array_shift($members);

            return new Command($commandName, $members, $options);
        }

        return new NullCommand();
    }

    /**
     * Constructor.
     *
     * @param string                     $name      The name of the command.
     * @param array|\Clinner\ValueHolder $arguments (Optional) arguments for the command.
     * @param array|\Clinner\ValueHolder $options   (Optional) options for the command.
     */
    public function __construct($name, $arguments = array(), $options = array())
    {
        $this
            ->setName($name)
            ->setArguments($arguments)
            ->setOptions($options);
    }

    /**
     * Get the name of this command.
     *
     * @return string
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Set the name of this command to $name.
     *
     * @param  string $name The name to set.
     *
     * @return \Clinner\Command\Command This instance, for a fluent API.
     */
    public function setName($name)
    {
        $this->_name = $name;

        return $this;
    }

    /**
     * Get the arguments for this command as a ValueHolder.
     *
     * @return \Clinner\ValueHolder
     */
    public function getArguments()
    {
        return $this->_arguments;
    }

    /**
     * Set this command's arguments as a whole.
     * $arguments might either be an array or a ValueHolder.
     *
     * @see    \Clinner\ValueHolder::create()
     *
     * @param  \Clinner\ValueHolder|array $arguments The arguments for this command.
     *
     * @return \Clinner\Command\Command This instance, for a fluent API.
     */
    public function setArguments($arguments)
    {
        $this->_arguments = ValueHolder::create($arguments);

        return $this;
    }

    /**
     * Get the options for this command as a ValueHolder.
     *
     * @return \Clinner\ValueHolder
     */
    public function getOptions()
    {
        return $this->_options;
    }

    /**
     * Set this command's options as a whole.
     * $options might either be an array or a ValueHolder.
     *
     * @see    \Clinner\ValueHolder::create()
     *
     * @param  \Clinner\ValueHolder|array $options The options for this command.
     *
     * @return \Clinner\Command\Command This instance, for a fluent API.
     */
    public function setOptions($options)
    {
        $this->_options = ValueHolder::create($options);

        return $this;
    }

    /**
     * Get a single option value for this command, optionally providing a default value
     * for it.
     *
     * @see    \Clinner\ValueHolder::get()
     *
     * @param  string $name    The name of the option.
     * @param  mixed  $default The default value for the option, in case it isn't set.
     *
     * @return mixed
     */
    public function getOption($name, $default = null)
    {
        return $this->_options->get($name, $default);
    }

    /**
     * Set a single option for this command.
     *
     * @param  string $name  Name of the option to set.
     * @param  mixed  $value Value for that option.
     *
     * @return \Clinner\Command\Command This instance, for a fluent API.
     */
    public function setOption($name, $value)
    {
        $this->_options->set($name, $value);

        return $this;
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
     * Get the exit code for this command.
     *
     * @return int
     */
    public function getExitCode()
    {
        return $this->_exitCode;
    }

    /**
     * Get this command's output.
     *
     * @return string
     */
    public function getOutput()
    {
        return $this->_output;
    }

    /**
     * Get the error output for this command.
     *
     * @return string
     */
    public function getErrorOutput()
    {
        return $this->_errorOutput;
    }

    /**
     * Get the output of this command as an array, splitting it with a given $delimiter.
     * If no output has been generated by this command, an empty array will be returned.
     *
     * @see explode
     *
     * @param  string $delimiter The boundary string.
     *
     * @return array
     */
    public function getOutputAsArray($delimiter = ' ')
    {
        return array_values(
            array_filter(
                explode($delimiter, strval($this->_output))
            )
        );
    }

    /**
     * Run this command with the given $input.
     * If this command has any other command piped to it, the other command
     * will also be run as well, with this command's output as its input.
     *
     * @param  string $input (Optional) input for this command.
     *
     * @return \Clinner\Command\Command This instance, for a fluent API.
     */
    public function run($input = null)
    {
        $this->_exitCode = $this->_run($input);

        return $this;
    }

    /**
     * Actually run this command and its piped commands chain, if applicable.
     * Return the exit code for such execution.
     *
     * @throws \RuntimeException If unable to run the command.
     *
     * @param  string $input Input to this command.
     *
     * @return int
     */
    protected function _run($input)
    {
        $this->_output = '';
        $this->_errorOutput = '';

        $descriptors = array(
            0 => array('pipe', 'r'),
            1 => array('pipe', 'w'),
            2 => array('pipe', 'w'),
        );
        $pipes = array();

        $childProcess = proc_open($this->toCommandString(), $descriptors, $pipes);

        if (!is_resource($childProcess)) {
            throw new \RuntimeException('Unable to run command: ' . $this->toCommandString());
        }

        if (null !== $input) {
            fwrite($pipes[0], $input);
            fclose($pipes[0]);
        }

        $output = stream_get_contents($pipes[1]);
        fclose($pipes[1]);

        $errorOutput = stream_get_contents($pipes[2]);
        fclose($pipes[2]);

        $exitCode = proc_close($childProcess);

        // Run the piped command, if any
        if ($this->hasPipedCommand()) {
            $pipedCommand = $this->getPipedCommand();

            $pipedCommand->run($output);

            $output      = $pipedCommand->getOutput();
            $exitCode    = $pipedCommand->getExitCode();
            $errorOutput = $pipedCommand->getErrorOutput();
        }

        $this->_output = $output;
        $this->_errorOutput = $errorOutput;

        return $exitCode;
    }

    /**
     * Get a string representation of this command with its arguments,
     * as if it would be written in a command-line interface when run.
     *
     * @param  bool $includePiped (Optional) indicates whether the resulting
     *                            string will include any piped command to this
     *                            one. Defaults to FALSE.
     *
     * @return string
     */
    public function toCommandString($includePiped = false)
    {
        $command = $this->getName();

        if (!$this->getArguments()->isEmpty()) {
            $args = array();

            $delimiter = $this->getOption('delimiter', self::DEFAULT_DELIMITER);

            foreach ($this->getArguments()->getAll() as $key => $value) {
                if (is_int($key)) {
                    $args[] = $value;
                } else {
                    $args[] = $key.$delimiter.$value;
                }
            }

            $command .= ' ' . implode(' ', $args);
        }

        if ($includePiped && $this->hasPipedCommand()) {
            $command .= sprintf(' %s %s', self::PIPE, $this->getPipedCommand()->toCommandString($includePiped));
        }

        return $command;
    }

    /**
     * Get the string representation of this command.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }
}
