<?php
/**
 * Part of Radic - Blade Extensions
 *
 * @package    Radic\BladeExtensions
 * @author     Robin Radic
 * @license    MIT License - http://radic.mit-license.org
 * @copyright  (c) 2011-2014, Robin Radic - Radic Technologies
 * @link       http://radic.nl
 */

return array(
    /*
     * Blacklisting of directives. These directives will not be extended. Example:
     *
     * 'blacklist' => array('foreach', 'set', 'debug')
     */
    'blacklist' => array(),

    /*
     * Prepend and append the debug output.
     */
    'debug' => array(
        'prepend' => '',
        'append' => ''
    )
);