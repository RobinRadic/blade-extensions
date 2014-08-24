<?php
/**
 * Part of Radic - Blade Extensions
 *
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
        /*
         * Prepend any code in front of our variable name
         *
         * The default config also checks if Kint is installed for sweet debug output.
         * Check https://github.com/raveren/kint.
         *
         */
        'prepend' => "<h1>DEBUG OUTPUT:</h1><pre><code><?php " . (class_exists('Kint') ? "Kint::dump(" : "var_dump("),

        /*
         * Append any code behind our variable name
         */
        'append' => ") ?></code></pre>"
    )
);