<?php

/*
 * This file is part of the Clinner library.
 *
 * (c) José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Clinner;


/**
 * ValueHolder
 * Value holder for any kind of array-like store that needs to have
 * accessors with an optional default value for undefined values.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class ValueHolder
{
    /**
     * Values in this holder.
     *
     * @var array
     */
    private $_values;
    
    /**
     * Create a new instance of ValueHolder with an optional initial set of values.
     * $initial might either be an array or another instance of ValueHolder, in which
     * case it will be returned as is.
     *
     * @param array|\Clinner\ValueHolder $initial (Optional) initial set of values.
     *
     * @return \Clinner\ValueHolder
     */
    static public function create($initial = array())
    {
        if ($initial instanceof self) {
            return $initial;
        } else {
            return new self($initial);
        }
    }
    
    /**
     * Constructor
     *
     * @param array $initial (Optional) initial values for the ValueHolder.
     */
    public function __construct(array $initial = array())
    {
        $this->_values = $initial;
    }
    
    /**
     * Overridden in order to allow atribute-like accessor for values in the
     * ValueHolder.
     */
    public function __get($name)
    {
        return $this->get($name);
    }
    
    /**
     * Overridden in order to allow atribute-like setter for values in the
     * ValueHolder.
     */
    public function __set($name, $value)
    {
        $this->set($name, $value);
    }
    
    /**
     * Get the value stored under key $name if it's set - otherwise return
     * $default.
     *
     * @param  string $name    The key name for the desired value.
     * @param  mixed  $default (Optional) a default value to return if $name is not set.
     *
     * @return mixed
     */
    public function get($name, $default = null)
    {
        if (array_key_exists($name, $this->_values)) {
            return $this->_values[$name];
        } else {
            return $default;
        }
    }
    
    /**
     * Set and store a value under key $name to $value.
     *
     * @param  string $name  The key name for the value to set.
     * @param  mixed  $value The value to set under key $name.
     *
     * @return ValueHolder This instance, for a fluent API.
     */
    public function set($name, $value)
    {
        $this->_values[$name] = $value;
        
        return $this;
    }
    
    /**
     * Reset this ValueHolder's values, clearing any of them.
     *
     * @return ValueHolder This instance, for a fluent API.
     */
    public function reset()
    {
        $this->_values = array();
        
        return $this;
    }
    
    /**
     * Set all the values stored in this ValueHolder to $values,
     * destroying any previously-set ones.
     *
     * @param  array $values The new values to set.
     *
     * @return ValueHolder This instance, for a fluent API.
     */
    public function setAll(array $values)
    {
        $this->_values = $values;
        
        return $this;
    }
    
    /**
     * Get all the values stored in this ValueHolder as an array.
     *
     * @return array
     */
    public function getAll()
    {
        return $this->_values;
    }

    /**
     * Get the number of arguments set to this ValueHolder.
     *
     * @return int
     */
    public function count()
    {
        return count($this->_values);
    }

    /**
     * Answer whether this ValueHolder is empty.
     *
     * @return bool
     */
    public function isEmpty()
    {
        return $this->count() === 0;
    }
}