<?php
namespace Radic\BladeExtensions\Contracts;

/**
 * This is the Stack.
 *
 * @package        Radic\BladeExtensions
 * @author         Caffeinated Dev Team
 * @copyright      Copyright (c) 2015, Caffeinated
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
interface Stack
{
    /**
     * start
     *
     * @return \Radic\BladeExtensions\Contracts\Stack
     */
    public function start();

    /**
     * end
     *
     * @return \Radic\BladeExtensions\Contracts\Stack
     */
    public function end();
}
