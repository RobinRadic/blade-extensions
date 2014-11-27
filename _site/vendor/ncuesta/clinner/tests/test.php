<?php

require_once __DIR__ . '/../vendor/autoload.php';

use \Clinner\Command\Command;
use \Clinner\Command\Callback;


$callbackCommand = new Callback(function($input) {
    foreach (explode("\n", $input) as $line) {
        if (false !== strchr($line, 'x')) {
            echo "$line\n";
        }
    }
});

$systemUsersCommand = Command::create('cat', array('/etc/passwd'))
    ->pipe(Command::create('grep', array('-v' => '^#'), array('delimiter' => ' ')))
    ->pipe(Command::create('cut', array('-d' => ':', '-f' => 1), array('delimiter' => '')))
    ->pipe($callbackCommand);

echo $systemUsersCommand->toCommandString(true) . "\n";

echo "\n";

$systemUsers = $systemUsersCommand
    ->run()
    ->getOutputAsArray("\n");

print_r($systemUsers);

echo "\n";

$testCommandString = 'cat /etc/hosts | grep localhost | tr -s " \t" -';

$testCommandFromString = Command::fromString($testCommandString);

echo $testCommandFromString->toCommandString(true) . "\n";

echo $testCommandFromString
    ->run()
    ->getOutput() . "\n";