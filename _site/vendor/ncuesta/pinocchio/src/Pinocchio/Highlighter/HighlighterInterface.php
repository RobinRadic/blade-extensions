<?php

/*
 * This file is part of the Pinocchio library.
 *
 * (c) José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pinocchio\Highlighter;


/**
 * Interface HighlighterInterface
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
interface HighlighterInterface
{
    /**
     * Highlight the code $source considering that it has been written
     * with the language provided.
     * This method should return the HTML snippet for the highlighted
     * source code.
     *
     * @param  string $language The language in which $code is written.
     * @param  string $source   The code to highlight.
     *
     * @return string
     */
    function highlight($language, $source);
}
