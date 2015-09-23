<?php
/**
 * Part of the Caffeinated PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Radic\BladeExtensions\Helpers;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Traits\Macroable;

/**
 * This is the HelperRepository.
 *
 * @package        Radic\BladeExtensions
 * @author         Caffeinated Dev Team
 * @copyright      Copyright (c) 2015, Caffeinated
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class HelperRepository
{
    use Macroable;

    protected $helpers;

    protected $container;

    /**
     * @inheritDoc
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->helpers   = [ ];
    }

    public function put($key, $data)
    {

        $this->helpers[ $key ] = $data;
    }

    public function has($key)
    {
        return isset($this->helpers[ $key ]);
    }

    public function get($key, $default = null)
    {
        return $this->has($key) ? $this->helpers[ $key ] : $default;
    }
}
