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

use \dflydev\markdown\MarkdownParser;
use \Pinocchio\Highlighter\HighlighterInterface;
use \Pinocchio\Highlighter\Pygments;


/**
 * Php parser for Pinocchio.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class Php implements ParserInterface
{
    // Parsing constants
    const TOKEN_NAME_COMMENT              = 'T_COMMENT';
    const TOKEN_NAME_DOC_COMMENT          = 'T_DOC_COMMENT';
    const CODEBLOCK_DELIMITER             = "\n//CODEBLOCK\n";
    const HIGHLIGHTED_CODEBLOCK_DELIMITER = '<span class="c1">//CODEBLOCK</span>';
    const TAB_AS_SPACES                   = '    ';
    const HIGHLIGHT_BLOCK_HTML_PATTERN    = '<div class="highlight"><pre>%s</pre></div>';

    // Comment-identifying regular expressions
    const REGEX_COMMENT_SINGLE_LINE         = '/\/\/([^\n]*)/sm';
    const REGEX_COMMENT_MULTILINE_START     = '/\/\*+/sm';
    const REGEX_COMMENT_MULTILINE_END       = '/\*+\//sm';
    const REGEX_COMMENT_MULTILINE_CONT      = '/\s*\*([^\n]*\n)/sm';
    const REGEX_COMMENT_MULTILINE_ONE_LINER = '/\/\*+([^\n]*)\*+\//sm';

    // Markdown-specific regular expressions
    const REGEX_DOCBLOCK_TYPE = '/(\s*)(@(return|param|throws|var))\s+([^\$\s]+)/';
    const REGEX_DOCBLOCK_ARG  = '/\s(@[^\s]+)/';
    const REGEX_DOCBLOCK_VAR  = '/(\s*)(\$[\w\d_]+)/';

    /**
     * Parse a Pinocchio instance.
     *
     * @param  \Pinocchio\Pinocchio                        $pinocchio   The Pinocchio instance to parse.
     * @param  \Pinocchio\Highlighter\HighlighterInterface $highlighter The highlighter to use (optional)
     *
     * @return \Pinocchio\Pinocchio
     */
    public function parse(\Pinocchio\Pinocchio $pinocchio, \Pinocchio\Highlighter\HighlighterInterface $highlighter = null) {
        if (null === $highlighter) {
            $highlighter = new Pygments();
        }

        $code      = '';
        // $docBlocks is initialized with an empty element for the '<?php' start of the code
        $docBlocks = array('');

        $previousToken   = null;
        $commentRegexSet = $this->getCommentRegexSet();

        foreach ($this->tokenize($pinocchio->getSource()) as $token) {
            if (is_array($token)) {
                if ($this->isComment(token_name($token[0]))) {
                    $last     = '';
                    $token[1] = str_replace("\t", self::TAB_AS_SPACES, $token[1]);

                    if (token_name($previousToken[0]) === self::TOKEN_NAME_COMMENT && token_name($token[0]) === self::TOKEN_NAME_COMMENT) {
                        $last = array_pop($docBlocks);
                    } else {
                        $code .= self::CODEBLOCK_DELIMITER;
                    }

                    $docBlocks[] = $last . preg_replace($commentRegexSet, '$1', $token[1]);
                } else {
                    $code .= $token[1];
                }
            } else {
                $code .= $token;
            }

            $previousToken = $token;
        }

        $codeBlocks = explode(
            self::HIGHLIGHTED_CODEBLOCK_DELIMITER,
            $highlighter->highlight('php', $code)
        );

        foreach ($codeBlocks as $codeBlock) {
            $pinocchio->addCodeBlock(
                sprintf(
                    self::HIGHLIGHT_BLOCK_HTML_PATTERN,
                    str_replace("\t", ' ', $codeBlock)
                )
            );
        }

        $pinocchio->setDocBlocks($this->parseDocblocks($docBlocks));

        return $pinocchio;
    }

    /**
     * Get the set of regular expressions that represent the different
     * comment blocks that might be found in the PHP code.
     *
     * @return array
     */
    public function getCommentRegexSet()
    {
        return array(
            self::REGEX_COMMENT_SINGLE_LINE,
            self::REGEX_COMMENT_MULTILINE_START,
            self::REGEX_COMMENT_MULTILINE_CONT,
            self::REGEX_COMMENT_MULTILINE_END,
            self::REGEX_COMMENT_MULTILINE_ONE_LINER,
        );
    }

    /**
     * Parse the given documentation blocks with a Markdown parser and return
     * the resulting formatted blocks as HTML snippets.
     *
     * @param  array $rawDocBlocks The raw documentation blocks to parse.
     *
     * @return array
     */
    protected function parseDocblocks($rawDocBlocks)
    {
        $parsedDocBlocks = array();
        $docBlockParser = new MarkdownParser();

        foreach ($rawDocBlocks as $docBlock) {
            $docBlock = preg_replace(self::REGEX_DOCBLOCK_TYPE, '$1$2 `$4` ', $docBlock);
            $docBlock = preg_replace(self::REGEX_DOCBLOCK_VAR, '$1`$2`', $docBlock);
            $docBlock = preg_replace(self::REGEX_DOCBLOCK_ARG, "\n<em class=\"docparam\">$1</em>", $docBlock);

            $parsedDocBlocks[] = $docBlockParser->transformMarkdown($docBlock);
        }

        return $parsedDocBlocks;
    }

    /**
     * Tokenize $source.
     *
     * @param  string $source The source code to tokenize.
     *
     * @return array
     */
    protected function tokenize($source)
    {
        return token_get_all($source);
    }

    /**
     * Answer whether $tokenName is a comment token name.
     *
     * @param  string $tokenName The token name to test.
     *
     * @return bool
     */
    protected function isComment($tokenName)
    {
        return in_array($tokenName, array(self::TOKEN_NAME_COMMENT, self::TOKEN_NAME_DOC_COMMENT));
    }
}
