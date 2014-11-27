<?php

/*
 * This file is part of the Clinner library.
 *
 * (c) José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clinner\Tests;

use Clinner\ValueHolder;


/**
 * ValueHolder test cases.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class ValueHolderTest extends \PHPUnit_Framework_TestCase
{
    public function testStaticCreateWithoutInitialValues()
    {
        $valueHolder = ValueHolder::create();
        
        $this->assertInstanceOf(
            '\\Clinner\\ValueHolder',
            $valueHolder
        );
        $this->assertAttributeEmpty('_values', $valueHolder);
    }
    
    public function testStaticCreateWithInitialValuesArray()
    {
        $initialValues = array(
            'key' => 'value',
        );
        
        $valueHolder = ValueHolder::create($initialValues);
        
        $this->assertInstanceOf(
            '\\Clinner\\ValueHolder',
            $valueHolder
        );
        $this->assertAttributeNotEmpty('_values', $valueHolder);
        $this->assertEquals($initialValues, $valueHolder->getAll());
    }
    
    public function testStaticCreateWithInitialValuesValueHolder()
    {
        $initialValues = array(
            'key' => 'value',
        );
        $sourceValueHolder = new ValueHolder($initialValues);
        
        $valueHolder = ValueHolder::create($sourceValueHolder);
        
        $this->assertSame($sourceValueHolder, $valueHolder);
    }
    
    public function testConstructorWithoutValues()
    {
        $valueHolder = new ValueHolder();
        $this->assertAttributeEmpty('_values', $valueHolder);
    }
    
    public function testConstructorWithValues()
    {
        $initialValues = array(
            'key' => 'value',
        );
        
        $valueHolder = new ValueHolder($initialValues);
        $this->assertAttributeNotEmpty('_values', $valueHolder);
        $this->assertEquals($initialValues, $valueHolder->getAll());
    }
    
    public function testAttributeLikeAccessor()
    {
        $initialValues = array(
            'key' => 'value',
            'other' => 'otherValue',
        );
        
        $valueHolder = new ValueHolder($initialValues);
        
        $this->assertEquals($initialValues['key'], $valueHolder->key);
        $this->assertEquals($initialValues['other'], $valueHolder->other);
        $this->assertNull($valueHolder->undefined);
    }
    
    public function testAttributeLikeSetter()
    {
        $valueHolder = new ValueHolder();
        
        $valueHolder->key = 'value';
        
        $this->assertEquals('value', $valueHolder->key);
        $this->assertNull($valueHolder->other);
    }
    
    public function testGet()
    {
        $valueHolder = new ValueHolder();
        
        $this->assertNull($valueHolder->get('key'));
        $this->assertEquals('default', $valueHolder->get('key', 'default'));
        $this->assertNull($valueHolder->get('key'));
    }
    
    public function testSet()
    {
        $valueHolder = new ValueHolder();
        
        $valueHolder->set('key', 'value');
        
        $this->assertEquals('value', $valueHolder->key);
    }
    
    public function testReset()
    {
        $initialValues = array(
            'key' => 'value',
        );
        $valueHolder = new ValueHolder($initialValues);
        
        $valueHolder->reset();
        
        $this->assertAttributeEmpty('_values', $valueHolder);
    }

    public function testSetAll()
    {
        $values = array(
            'key' => 'value',
            'other' => 'otherValue',
        );
        
        $valueHolder = new ValueHolder();
        
        $valueHolder->setAll($values);
        
        $this->assertEquals($values, $valueHolder->getAll());
    }
    
    public function testGetAll()
    {
        $initialValues = array(
            'key' => 'value',
            'other' => 'otherValue',
        );
        
        $valueHolder = new ValueHolder($initialValues);
        
        $this->assertEquals($initialValues, $valueHolder->getAll());
    }

    /**
     * @dataProvider getInitialValues
     */
    public function testCount($initialValues)
    {
        $valueHolder = new ValueHolder($initialValues);

        $this->assertEquals(count($initialValues), $valueHolder->count());
    }

    /**
     * @dataProvider getInitialValues
     */
    public function testIsEmpty($initialValues)
    {
        $valueHolder = new ValueHolder($initialValues);

        $this->assertEquals(empty($initialValues), $valueHolder->isEmpty());
    }

    /**
     * Data provider for testCount() and testIsEmpty().
     */
    public function getInitialValues()
    {
        return array(
            array(array()),
            array(array('key' => 'value')),
            array(array('key' => 'value', 'other' => 'otherValue')),
        );
    }
}