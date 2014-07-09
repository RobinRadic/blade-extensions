<?php

class ForEachLoopTest extends Orchestra\Testbench\TestCase
{
    protected $loopData;
    public function setUp()
    {
        parent::setUp();
        $this->loopData = array(
            array('name' => 'micheal', 'age' => 55, 'gender' => 'male'),
            array('name' => 'anton', 'age' => 12, 'gender' => 'male'),
            array('name' => 'claire', 'age' => 45, 'gender' => 'female'),
            array('name' => 'thomas', 'age' => 22, 'gender' => 'male'),
            array('name' => 'richard', 'age' => 34, 'gender' => 'male'),
            array('name' => 'donal', 'age' => 85, 'gender' => 'does-not-know')
        );
    }

    public function testLoopData()
    {
        $this->assertTrue(true);
    }
    public function testLoopStacking()
    {
        $this->assertTrue(true);
    }

}