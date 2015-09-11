<?php
/**
 * Part of the Caffeinated PHP packages.
 *
 * MIT License and copyright information bundled with this package in the LICENSE file
 */
namespace Radic\BladeExtensions\Helpers;

use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Collection;

/**
 * This is the HelperRepository.
 *
 * @package        Radic\BladeExtensions
 * @author         Caffeinated Dev Team
 * @copyright      Copyright (c) 2015, Caffeinated
 * @license        https://tldrlegal.com/license/mit-license MIT License
 */
class HelperRepository extends Collection
{
    protected $container;
    /**
     * @inheritDoc
     */
    public function __construct(Container $container)
    {
        parent::__construct([]);

        $this->container = $container;

        $helpers = [
            'loop' => LoopFactory::class,
            'embed' => EmbedStacker::class
        ];

        foreach($helpers as $name => $class){
            $this->put($name, $container->make($class));
        }
    }


}
