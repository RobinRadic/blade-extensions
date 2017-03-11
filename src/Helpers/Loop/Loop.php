<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright 2017 Robin Radic
 * @license https://radic.mit-license.org MIT License
 * @version 7.0.0 Radic\BladeExtensions
 */

namespace Radic\BladeExtensions\Helpers\Loop;

/**
 * Represents the $loop variable in the foreach directive. Handles all data.
 *
 * @version        2.1.0
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright      2011-2015, Robin Radic - Radic Technologies
 * @link           http://robin.radic.nl/blade-extensions
 *
 * @property bool      $odd
 * @property bool      $even
 *
 * @property int       index        The index of the current loop iteration (starts at 0).
 * @property int       $index1      The current loop iteration (starts at 1).
 * @property int       iteration    The current loop iteration (starts at 1).
 *
 * @property int       $revindex1   The iteration remaining in the loop.
 * @property int       $revindex    The iteration remaining in the loop.
 * @property int       remaining    The iteration remaining in the loop.
 *
 * @property int       count        The total number of items in the array being iterated.
 * @property int       $total       The total number of items in the array being iterated.
 * @property bool      first        Whether this is the first iteration through the loop.
 * @property bool      last         Whether this is the last iteration through the loop.
 * @property int       depth        The nesting level of the current loop.
 * @property Loop|null parent       When in a nested loop, the parent's loop variable.
 * @property Loop|null $parentLoop  When in a nested loop, the parent's loop variable.
 */
class Loop
{
    /**
     * The array that is being iterated.
     *
     * @var array
     */
    protected $items = [];

    /**
     * The data for the current $loop item.
     *
     * @var array
     */
    protected $data;

    /**
     * The parent loop, if any.
     *
     * @var Loop
     */
    protected $parentLoop;

    protected $loopHelper;

    protected $aliases = [];

    /**
     * Sets the parent loop.
     *
     * @param Loop $parentLoop
     * {@inheritdoc}
     */
    public function setParentLoop(Loop $parentLoop)
    {
        $this->parentLoop = $parentLoop;
        $this->data['parent'] = $parentLoop;
    }

    /**
     * Returns the full loop stack of the LoopFactory.
     *
     * @return array
     */
    public function getLoopStack()
    {
        return $this->loopHelper->getStack();
    }

    /**
     * Resets the loop stack of the LoopFactory.
     */
    public function resetLoopStack()
    {
        $this->loopHelper->reset();
    }

    /**
     * Instantiates the class.
     *
     * @param \Radic\BladeExtensions\Helpers\Loop\LoopHelper $loopHelper
     * @param array                                          $items The array that's being iterated
     */
    public function __construct(LoopHelper $loopHelper, $items)
    {
        $this->loopHelper = $loopHelper;
        $this->setItems($items);
    }

    /**
     * Sets the array to monitor.
     *
     * @param array $items The array that's being iterated
     */
    public function setItems($items)
    {
        if (isset($data)) {
            return;
        }
        $this->items = $items;
        $total = count($items);
        $this->data = [
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

    /**
     * getItems method.
     *
     * @return array
     */
    public function getItems()
    {
        return $this->items;
    }

    /**
     * Magic method to access the loop data properties.
     *
     * @param $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        $aliases = [
            'iteration' => 'index1',
            'remaining' => 'revindex1',
            'parentLoop'    => 'parent',
            'count' => 'length',
        ];
        if (array_key_exists($key, $aliases)) {
            return $this->data[$aliases[$key]];
        }

        return $this->data[$key];
    }

    /**
     * __set method.
     *
     * @param $key
     * @param $val
     *
     * @return void
     */
    public function __set($key, $val)
    {
        // do not allow setting the data
    }

    /**
     * __isset method.
     *
     * @param $key
     *
     * @return bool
     */
    public function __isset($key)
    {
        return isset($this->data[$key]);
    }

    /**
     * To be called first in a loop before anything else.
     */
    public function before()
    {
        if ($this->data['index'] % 2 == 0) {
            $this->data['odd'] = false;
            $this->data['even'] = true;
        } else {
            $this->data['odd'] = true;
            $this->data['even'] = false;
        }
        if ($this->data['index'] == 0) {
            $this->data['first'] = true;
        } else {
            $this->data['first'] = false;
        }
        if ($this->data['revindex'] == 0) {
            $this->data['last'] = true;
        } else {
            $this->data['last'] = false;
        }
    }

    /**
     * To be called last in a loop after everything else.
     */
    public function after()
    {
        $this->data['index']++;
        $this->data['index1']++;
        $this->data['revindex']--;
        $this->data['revindex1']--;
    }
}
