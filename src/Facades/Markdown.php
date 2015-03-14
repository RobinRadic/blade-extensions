<?php
/**
 * The Markdown FAcad
 */
namespace Radic\BladeExtensions\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * The Markdown Facad
 *
 * @package            Radic\BladeExtensions
 * @subpackage         Facades
 * @version            2.1.0
 * @author             Robin Radic
 * @license            MIT License - http://radic.mit-license.org
 * @copyright          2011-2015, Robin Radic
 * @link               http://robin.radic.nl/blade-extensions
 *
 */
class Markdown extends Facade
{
    /**
     * {@inheritdoc}
     */
    public static function getFacadeAccessor()
    {
        return 'markdown';
    }
}
