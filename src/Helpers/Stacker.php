<?php
/**
 * Copyright (c) 2016. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2016 (c) Robin Radic
 * @license https://radic.mit-license.org The MIT License
 */

/**
 * Manages the Loop instances
 */
namespace Radic\BladeExtensions\Helpers;

use Illuminate\Contracts\Container\Container;

/**
 * Manages the Loop instances
 *
 * @package        Radic\BladeExtensions
 * @subpackage     Helpers
 * @version        2.1.0
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright      (2011-2014, Robin Radic - Radic Technologies
 * @link           http://robin.radic.nl/blade-extensions
 *
 */
abstract class Stacker
{
    protected $container;

    /**
     * The stack of Loop instances
     *
     * @var array $stack
     */
    protected $stack = [ ];

    /**
     * @inheritDoc
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }


    /**
     * Adds a Loop to the stack
     */
    public function start()
    {
        $stackItem = static::create(func_get_args());
        array_push($this->stack, $stackItem);
        $stackItem->start();
        return $stackItem;
    }

    /**
     * create
     *
     * @return mixed
     */
    abstract protected function create($args = [ ]);

    /**
     * Returns the stack
     *
     * @return array
     */
    public function getStack()
    {
        return $this->stack;
    }

    /**
     * Resets the stack
     */
    public function reset()
    {
        $this->stack = [ ];
    }

    /**
     * To be called first inside the foreach loop. Returns the current loop
     *
     * @return mixed $current The current loop data
     */
    public function current()
    {
        $current = end($this->stack);

        return $current;
    }

    /**
     * To be called before the end of the loop
     */
    public function end()
    {
        if ( !$this->isEmpty() ) {
            static::current()->end();
            array_pop($this->stack);
        }
    }

    public function isEmpty()
    {
        return count($this->stack) === 0;
    }

    /**
     * get container value
     *
     * @return \Illuminate\Contracts\Container\Container
     */
    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Set the container value
     *
     * @param \Illuminate\Contracts\Container\Container $container
     *
     * @return Stacker
     */
    public function setContainer($container)
    {
        $this->container = $container;

        return $this;
    }
}
