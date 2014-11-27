<?php

/*
 * This file is part of the Clinner library.
 *
 * (c) José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clinner\Command\Tests;

use Clinner\Command\Command;
use Clinner\ValueHolder;


/**
 * Command test cases.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class CommandTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @covers \Clinner\Command\Command::create
     */
    public function testStaticCreateNoArgsNoOpts()
    {
        $name = 'ls';

        $command = Command::create($name);

        $this->assertInstanceOf('\\Clinner\\Command\\Command', $command);
        $this->assertAttributeEquals($name, '_name', $command);
        $this->assertAttributeInstanceOf('\\Clinner\\ValueHolder', '_arguments', $command);
        $this->assertAttributeInstanceOf('\\Clinner\\ValueHolder', '_options', $command);
        $this->assertAttributeEmpty('_next', $command);
        $this->assertAttributeEmpty('_exitCode', $command);
        $this->assertAttributeEmpty('_output', $command);
    }

    /**
     * @covers \Clinner\Command\Command::create
     */
    public function testStaticCreateWithArgsAndOpts()
    {
        $name = 'ls';
        $args = array('first' => 'value', 'second' => 'second value');
        $opts = array('some_option' => 'some value');

        $command = Command::create($name, $args, $opts);

        $this->assertInstanceOf('\\Clinner\\Command\\Command', $command);
        $this->assertAttributeEquals($name, '_name', $command);
        $this->assertAttributeInstanceOf('\\Clinner\\ValueHolder', '_arguments', $command);
        $this->assertAttributeInstanceOf('\\Clinner\\ValueHolder', '_options', $command);
        $this->assertAttributeEmpty('_next', $command);
        $this->assertAttributeEmpty('_exitCode', $command);
        $this->assertAttributeEmpty('_output', $command);
    }

    /**
     * @covers \Clinner\Command\Command::fromString
     * @covers \Clinner\Command\Command::parse
     */
    public function testStaticFromStringNoCommands()
    {
        $command = Command::fromString('');

        $this->assertInstanceOf('\\Clinner\\Command\\NullCommand', $command);
    }

    /**
     * @covers \Clinner\Command\Command::fromString
     * @covers \Clinner\Command\Command::parse
     */
    public function testStaticFromStringOneCommand()
    {
        $commandString = 'cat ~/test.html';

        $command = Command::fromString($commandString);

        $this->assertInstanceOf('\\Clinner\\Command\\Command', $command);

        // Test that the inverse function also works
        $this->assertEquals($commandString, $command->toCommandString());
    }

    /**
     * @covers \Clinner\Command\Command::fromString
     * @covers \Clinner\Command\Command::parse
     */
    public function testStaticFromStringManyCommands()
    {
        $commandString = 'cat ~/test.html | tr -s " " | cut -d: -f2 | wc';
        $commandsCount = 4;

        $command = Command::fromString($commandString);

        $this->assertInstanceOf('\\Clinner\\Command\\Command', $command);

        // Test that the inverse function also works
        $this->assertEquals($commandString, $command->toCommandString(true));

        $count = 0;
        while (null !== $command) {
            $count++;
            $command = $command->getPipedCommand();
        }

        $this->assertEquals($commandsCount, $count);
    }

    /**
     * @covers \Clinner\Command\Command::__construct
     */
    public function testConstructorDefaults()
    {
        $name = 'some-command';

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(array('setName', 'setArguments', 'setOptions'))
            ->getMock();

        $command->expects($this->once())
            ->method('setName')
            ->with($this->equalTo($name))
            ->will($this->returnSelf());

        $command->expects($this->once())
            ->method('setArguments')
            ->with($this->equalTo(array()))
            ->will($this->returnSelf());

        $command->expects($this->once())
            ->method('setOptions')
            ->with($this->equalTo(array()))
            ->will($this->returnSelf());

        $command->__construct($name);
    }

    /**
     * @covers \Clinner\Command\Command::__construct
     */
    public function testConstructorWithValues()
    {
        $name = 'command-name';
        $args = array('first' => 'value');
        $opts = array('delimiter' => '?');

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(array('setName', 'setArguments', 'setOptions'))
            ->getMock();

        $command->expects($this->once())
            ->method('setName')
            ->with($this->equalTo($name))
            ->will($this->returnSelf());

        $command->expects($this->once())
            ->method('setArguments')
            ->with($this->equalTo($args))
            ->will($this->returnSelf());

        $command->expects($this->once())
            ->method('setOptions')
            ->with($this->equalTo($opts))
            ->will($this->returnSelf());

        $command->__construct($name, $args, $opts);
    }

    /**
     * @covers \Clinner\Command\Command::getName
     */
    public function testGetName()
    {
        $name = 'command-name';

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $this->_setPrivateProperty($command, '_name', $name);

        $this->assertEquals($name, $command->getName());
    }

    /**
     * @covers \Clinner\Command\Command::setName
     */
    public function testSetName()
    {
        $name = 'command';

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $this->assertAttributeEmpty('_name', $command);

        $response = $command->setName($name);

        $this->assertAttributeEquals($name, '_name', $command);
        $this->assertSame($command, $response);
    }

    /**
     * @covers \Clinner\Command\Command::getArguments
     */
    public function testGetArguments()
    {
        $args = new ValueHolder(array('some' => 'arg'));

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $this->_setPrivateProperty($command, '_arguments', $args);

        $this->assertEquals($args, $command->getArguments());
    }

    /**
     * @covers \Clinner\Command\Command::setArguments
     */
    public function testSetArgumentsWithArray()
    {
        $args = array('some' => 'arg', 'another' => 'argument');

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $this->assertAttributeEmpty('_arguments', $command);

        $response = $command->setArguments($args);

        $instanceValueHolder = $this->_getPrivateProperty($command, '_arguments');

        $this->assertInstanceof('\\Clinner\\ValueHolder', $instanceValueHolder);
        $this->assertAttributeEquals($args, '_values', $instanceValueHolder);
        $this->assertSame($command, $response);
    }

    /**
     * @covers \Clinner\Command\Command::setArguments
     */
    public function testSetArgumentsWithValueHolder()
    {
        $args = $this->getMock('\\Clinner\\ValueHolder');

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $this->assertAttributeEmpty('_arguments', $command);

        $response = $command->setArguments($args);

        $this->assertAttributeInstanceof('\\Clinner\\ValueHolder', '_arguments', $command);
        $this->assertAttributeEquals($args, '_arguments', $command);
        $this->assertSame($command, $response);
    }

    /**
     * @covers \Clinner\Command\Command::getOptions
     */
    public function testGetOptions()
    {
        $opts = new ValueHolder(array('one' => 'option'));

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $this->_setPrivateProperty($command, '_options', $opts);

        $this->assertEquals($opts, $command->getOptions());
    }

    /**
     * @covers \Clinner\Command\Command::setOptions
     */
    public function testSetOptionsWithArray()
    {
        $opts = array('some' => 'opt', 'another' => 'nifty option');

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $this->assertAttributeEmpty('_options', $command);

        $response = $command->setOptions($opts);

        $instanceValueHolder = $this->_getPrivateProperty($command, '_options');

        $this->assertInstanceof('\\Clinner\\ValueHolder', $instanceValueHolder);
        $this->assertAttributeEquals($opts, '_values', $instanceValueHolder);
        $this->assertSame($command, $response);
    }

    /**
     * @covers \Clinner\Command\Command::setOptions
     */
    public function testSetOptionsWithValueHolder()
    {
        $opts = $this->getMock('\\Clinner\\ValueHolder');

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $this->assertAttributeEmpty('_options', $command);

        $response = $command->setOptions($opts);

        $this->assertAttributeInstanceof('\\Clinner\\ValueHolder', '_options', $command);
        $this->assertAttributeEquals($opts, '_options', $command);
        $this->assertSame($command, $response);
    }

    /**
     * @covers \Clinner\Command\Command::getOption
     */
    public function testGetOptionNoDefault()
    {
        $optName = 'option-name';

        $opts = $this->getMock('\\Clinner\\ValueHolder');
        $opts->expects($this->once())
            ->method('get')
            ->with($this->equalTo($optName))
            ->will($this->returnValue(null));

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $this->_setPrivateProperty($command, '_options', $opts);

        $response = $command->getOption($optName);

        $this->assertNull($response);
    }

    /**
     * @covers \Clinner\Command\Command::getOption
     */
    public function testGetOptionWithDefault()
    {
        $optName = 'option-name';
        $defaultValue = 'default';

        $opts = $this->getMock('\\Clinner\\ValueHolder');
        $opts->expects($this->once())
            ->method('get')
            ->with($this->equalTo($optName), $this->equalTo($defaultValue))
            ->will($this->returnValue($defaultValue));

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $this->_setPrivateProperty($command, '_options', $opts);

        $response = $command->getOption($optName, $defaultValue);

        $this->assertEquals($defaultValue, $response);
    }

    /**
     * @covers \Clinner\Command\Command::setOption
     */
    public function testSetOption()
    {
        $optName = 'option-name';
        $optValue = 'option-value';

        $opts = $this->getMock('\\Clinner\\ValueHolder');
        $opts->expects($this->once())
            ->method('set')
            ->with($this->equalTo($optName), $this->equalTo($optValue));

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();
        $this->_setPrivateProperty($command, '_options', $opts);

        $response = $command->setOption($optName, $optValue);

        $this->assertSame($command, $response);
    }

    /**
     * @covers \Clinner\Command\Command::pipe
     */
    public function testPipe()
    {
        $this->markTestIncomplete('TODO: Test pipe() method.');
    }

    /**
     * @covers \Clinner\Command\Command::getPipedCommand
     */
    public function testGetPipedCommand()
    {
        $pipeableCommandMock = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();
        $this->_setPrivateProperty($command, '_next', $pipeableCommandMock);

        $this->assertSame($pipeableCommandMock, $command->getPipedCommand());
    }

    /**
     * @covers \Clinner\Command\Command::hasPipedCommand
     */
    public function testHasPipedCommandWithCommand()
    {
        $pipeableCommandMock = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();
        $this->_setPrivateProperty($command, '_next', $pipeableCommandMock);

        $this->assertTrue($command->hasPipedCommand());
    }

    /**
     * @covers \Clinner\Command\Command::hasPipedCommand
     */
    public function testHasPipedCommandWithoutCommand()
    {
        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();

        $this->assertFalse($command->hasPipedCommand());
    }

    /**
     * @covers \Clinner\Command\Command::getExitCode
     */
    public function testGetExitCode()
    {
        $exitCode = 12;

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();
        $this->_setPrivateProperty($command, '_exitCode', $exitCode);

        $this->assertEquals($exitCode, $command->getExitCode());
    }

    /**
     * @covers \Clinner\Command\Command::getOutput
     */
    public function testGetOutput()
    {
        $output = 'Some nice output from some commands.';

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();
        $this->_setPrivateProperty($command, '_output', $output);

        $this->assertEquals($output, $command->getOutput());
    }

    /**
     * @covers \Clinner\Command\Command::getOutputAsArray
     * @dataProvider getDataSetsForGetOutputAsArray
     */
    public function testGetOutputAsArray($output, $delimiter, $expectedResponse)
    {
        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();
        $this->_setPrivateProperty($command, '_output', $output);

        $this->assertEquals($expectedResponse, $command->getOutputAsArray($delimiter));
    }

    /**
     * @covers \Clinner\Command\Command::run
     * @covers \Clinner\Command\Command::_run
     */
    public function testRun()
    {
        $this->markTestIncomplete('TODO: Test the run() method.');
    }

    /**
     * @covers \Clinner\Command\Command::getErrorOutput
     */
    public function testGetErrorOutput()
    {
        $expectedValue = 'Nasty error output';

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(null)
            ->getMock();
        $this->_setPrivateProperty($command, '_errorOutput', $expectedValue);

        $this->assertEquals($expectedValue, $command->getErrorOutput());
    }

    /**
     * @covers \Clinner\Command\Command::toCommandString
     */
    public function testToCommandStringNoArgsNoPipedCommands()
    {
        $commandName = 'cmd';

        $valueHolderMock = $this->getMockBuilder('\\Clinner\\ValueHolder')
            ->disableOriginalConstructor()
            ->setMethods(array('isEmpty'))
            ->getMock();
        $valueHolderMock->expects($this->once())
            ->method('isEmpty')
            ->will($this->returnValue(true));

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(array('getName', 'getArguments'))
            ->getMock();
        $command->expects($this->once())
            ->method('getName')
            ->will($this->returnValue($commandName));
        $command->expects($this->once())
            ->method('getArguments')
            ->will($this->returnValue($valueHolderMock));

        $response = $command->toCommandString(false);

        $this->assertEquals($commandName, $response);
    }

    /**
     * @covers \Clinner\Command\Command::toCommandString
     */
    public function testToCommandStringWithArgsNoPipedCommands()
    {
        $commandName = 'cmd';
        $delimiter = '=';
        $arguments = array(
            '--arg',
            '-v' => '1',
        );
        $expectedString = 'cmd --arg -v=1';

        $valueHolderMock = $this->getMockBuilder('\\Clinner\\ValueHolder')
            ->disableOriginalConstructor()
            ->setMethods(array('isEmpty', 'getAll'))
            ->getMock();
        $valueHolderMock->expects($this->once())
            ->method('isEmpty')
            ->will($this->returnValue(false));
        $valueHolderMock->expects($this->once())
            ->method('getAll')
            ->will($this->returnValue($arguments));

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(array('getName', 'getArguments', 'getOption'))
            ->getMock();
        $command->expects($this->once())
            ->method('getName')
            ->will($this->returnValue($commandName));
        $command->expects($this->exactly(2))
            ->method('getArguments')
            ->will($this->returnValue($valueHolderMock));
        $command->expects($this->once())
            ->method('getOption')
            ->with($this->equalTo('delimiter'), $this->equalTo(Command::DEFAULT_DELIMITER))
            ->will($this->returnValue($delimiter));

        $response = $command->toCommandString(false);

        $this->assertEquals($expectedString, $response);
    }

    /**
     * @covers \Clinner\Command\Command::toCommandString
     */
    public function testToCommandStringNoArgsWithPipedCommands()
    {
        $commandName = 'cmd';
        $pipedCommandName = 'cmd2';
        $expectedString = 'cmd ' . Command::PIPE . ' cmd2';

        $valueHolderMock = $this->getMockBuilder('\\Clinner\\ValueHolder')
            ->disableOriginalConstructor()
            ->setMethods(array('isEmpty'))
            ->getMock();
        $valueHolderMock->expects($this->once())
            ->method('isEmpty')
            ->will($this->returnValue(true));

        $pipedCommandMock = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(array('toCommandString'))
            ->getMock();
        $pipedCommandMock->expects($this->once())
            ->method('toCommandString')
            ->with($this->equalTo(true))
            ->will($this->returnValue($pipedCommandName));

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(array('getName', 'getArguments', 'hasPipedCommand', 'getPipedCommand'))
            ->getMock();
        $command->expects($this->once())
            ->method('getName')
            ->will($this->returnValue($commandName));
        $command->expects($this->once())
            ->method('getArguments')
            ->will($this->returnValue($valueHolderMock));
        $command->expects($this->once())
            ->method('hasPipedCommand')
            ->will($this->returnValue(true));
        $command->expects($this->once())
            ->method('getPipedCommand')
            ->will($this->returnValue($pipedCommandMock));

        $response = $command->toCommandString(true);

        $this->assertEquals($expectedString, $response);
    }

    /**
     * @covers \Clinner\Command\Command::__toString
     */
    public function testToString()
    {
        $name = 'Command name';

        $command = $this->getMockBuilder('\\Clinner\\Command\\Command')
            ->disableOriginalConstructor()
            ->setMethods(array('getName'))
            ->getMock();
        $command->expects($this->once())
            ->method('getName')
            ->will($this->returnValue($name));

        $this->assertEquals($name, $command->__toString());
    }

    /**
     * Data provider for getOutputAsArray
     *
     * @return array
     */
    public function getDataSetsForGetOutputAsArray()
    {
        return array(
            array('', ' ', array()),
            array('    ', "\n", array('    ')),
            array("abc\n\ndef ", "\n", array('abc', 'def ')),
        );
    }

    /**
     * Set a private property to a Command $object.
     *
     * @param \Clinner\Command\Command $object The object to update.
     * @param string                   $name   The private property name.
     * @param mixed                    $value  The new value for the property.
     */
    protected function _setPrivateProperty($object, $name, $value)
    {
        $property = new \ReflectionProperty(
            '\\Clinner\\Command\\Command',
            $name
        );

        $property->setAccessible(true);
        $property->setValue($object, $value);
    }

    /**
     * Get the value of a private property from a Command $object.
     *
     * @param \Clinner\Command\Command $object The object to inspect.
     * @param string                   $name   The private property name.
     *
     * @return mixed
     */
    protected function _getPrivateProperty($object, $name)
    {
        $property = new \ReflectionProperty(
            '\\Clinner\\Command\\Command',
            $name
        );

        $property->setAccessible(true);

        return $property->getValue($object);
    }
}