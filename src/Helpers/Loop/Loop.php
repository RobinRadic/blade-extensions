<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2017 (c) Robin Radic
 * @license https://radic.mit-license.org The MIT License
 */

/**
 * Represents the $loop variable in the foreach directive. Handles all data.
 */
namespace Radic\BladeExtensions\Helpers\Loop;

/**
 * Represents the $loop variable in the foreach directive. Handles all data.
 *
 * @package        Radic\BladeExtensions
 * @subpackage     Helpers
 * @version        2.1.0
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright      2011-2015, Robin Radic - Radic Technologies
 * @link           http://robin.radic.nl/blade-extensions
 *
 *
 * @property int  $index1
 * @property int  $index
 * @property int  $revindex1
 * @property int  $revindex
 * @property bool $first
 * @property bool $last
 * @property bool $odd
 * @property bool $even
 * @property int  $total
 * @property Loop $parentLoop
 *
 *
 */
class Loop
{

    /**
     * The array that is being iterated
     *
     * @var array
     */
    protected $items = [];

    /**
     * The data for the current $loop item
     *
     * @var array
     */
    protected $data;

    /**
     * The parent loop, if any
     *
     * @var Loop
     */
    protected $parentLoop;

    protected $loopFactory;

    /**
     * Sets the parent loop
     *
     * @param Loop $parentLoop
     * {@inheritdocs}
     */
    public function setParentLoop(Loop $parentLoop)
    {
        $this->parentLoop       = $parentLoop;
        $this->data[ 'parent' ] = $parentLoop;
    }

    /**
     * Returns the full loop stack of the LoopFactory
     *
     * @return array
     */
    public function getLoopStack()
    {
        return $this->loopFactory->getStack();
    }

    /**
     * Resets the loop stack of the LoopFactory
     */
    public function resetLoopStack()
    {
        $this->loopFactory->reset();
    }

    /**
     * Instantiates the class
     *
     * @param array $items The array that's being iterated
     */
    public function __construct(LoopHelper $loopFactory, $items)
    {
        $this->loopFactory = $loopFactory;
        $this->setItems($items);
    }

    /**
     * Sets the array to monitor
     *
     * @param array $items The array that's being iterated
     */
    public function setItems($items)
    {
        if ( isset($data) ) {
            return;
        }
        $this->items = $items;
        $total       = count($items);
        $this->data  = [
            'index1'    => 1,
            'index'     => 0,
            'revindex1' => $total,
            'revindex'  => $total - 1,
            'first'     => true,
            'last'      => false,
            'odd'       => false,
            'even'      => true,
            'length'    => $total,
        ];
    }

    public function getItems()
    {
        return $this->items;
    }

    /**
     * Magic method to access the loop data properties
     *
     * @param $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->data[ $key ];
    }

    public function __set($key, $val)
    {
        // do not allow setting the data
    }

    public function __isset($key)
    {
        return isset($this->data[ $key ]);
    }

    /**
     * To be called first in a loop before anything else
     */
    public function before()
    {
        if ( $this->data[ 'index' ] % 2 == 0 ) {
            $this->data[ 'odd' ]  = false;
            $this->data[ 'even' ] = true;
        } else {
            $this->data[ 'odd' ]  = true;
            $this->data[ 'even' ] = false;
        }
        if ( $this->data[ 'index' ] == 0 ) {
            $this->data[ 'first' ] = true;
        } else {
            $this->data[ 'first' ] = false;
        }
        if ( $this->data[ 'revindex' ] == 0 ) {
            $this->data[ 'last' ] = true;
        } else {
            $this->data[ 'last' ] = false;
        }
    }

    /**
     * To be called last in a loop after everything else
     */
    public function after()
    {
        $this->data[ 'index' ]++;
        $this->data[ 'index1' ]++;
        $this->data[ 'revindex' ]--;
        $this->data[ 'revindex1' ]--;
    }
}
