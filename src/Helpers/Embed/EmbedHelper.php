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

namespace Radic\BladeExtensions\Helpers\Embed;

use Radic\BladeExtensions\Helpers\Embed;
use Radic\BladeExtensions\Helpers\Stacker;

/**
 * Manages the Loop instances.
 *
 * @version        2.1.0
 * @author         Robin Radic
 * @license        MIT License - http://radic.mit-license.org
 * @copyright      (2011-2014, Robin Radic - Radic Technologies
 * @link           http://robin.radic.nl/blade-extensions
 */
class EmbedHelper extends Stacker
{
    /**
     * create.
     *
     * @param array $args
     *
     * @return \Radic\BladeExtensions\Helpers\Embed\EmbedStack
     */
    protected function create($args = [])
    {
        $viewPath = $args[0];
        $vars = isset($args[1]) ? $args[1] : [];
        $embed = $this->getContainer()->make(Embed\EmbedStack::class, compact('viewPath', 'vars'));

        return $embed;
    }
}
