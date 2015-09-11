<?php
/**
 * Manages the Loop instances
 */
namespace Radic\BladeExtensions\Helpers;

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
class EmbedStacker extends Stacker
{

    /**
     * create
     *
     * @return Embed
     */
    protected function create($args = [ ])
    {
        $viewPath = $args[0];
        $vars = isset($args[1]) ? $args[1] : [];
        $embed = $this->getContainer()->make(Embed::class, compact('viewPath', 'vars'));
        return $embed;
    }


}
