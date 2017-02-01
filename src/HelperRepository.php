<?php
/**
 * Copyright (c) 2016. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright Copyright 2016 (c) Robin Radic
 * @license https://radic.mit-license.org The MIT License
 */

namespace Radic\BladeExtensions;

use Illuminate\Support\Traits\Macroable;

/**
 * This is the HelperRepository.
 *
 * @author         Caffeinated Dev Team
 * @copyright      Copyright (c) 2015, Caffeinated
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class HelperRepository
{
    use Macroable;

    protected $helpers;

    public function __construct()
    {
        $this->helpers = [];
    }

    public function put($key, $data)
    {
        $this->helpers[$key] = $data;
    }

    public function has($key)
    {
        return isset($this->helpers[$key]);
    }

    public function get($key, $default = null)
    {
        return $this->has($key) ? $this->helpers[$key] : $default;
    }
}
