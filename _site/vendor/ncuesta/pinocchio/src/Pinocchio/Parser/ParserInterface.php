<?php

/*
 * This file is part of the Pinocchio library.
 *
 * (c) José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pinocchio\Parser;


/**
 * Parser Interface.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
interface ParserInterface
{
    /**
     * Parse a Pinocchio instance.
     *
     * @param  \Pinocchio\Pinocchio                        $pinocchio   The Pinocchio instance to parse.
     * @param  \Pinocchio\Highlighter\HighlighterInterface $highlighter The highlighter to use (optional)
     *
     * @return \Pinocchio\Pinocchio
     */
    function parse(
        \Pinocchio\Pinocchio $pinocchio,
        \Pinocchio\Highlighter\HighlighterInterface $highlighter = null
    );
}
