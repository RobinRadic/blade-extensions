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

use \Clinner\Command\Command;
use \Guzzle\Http\Client;


/**
 * Pygments highlighter.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class Pygments implements HighlighterInterface
{
    const PYGMENTS_BINARY_NAME = 'pygmentize';
    const PYGMENTS_SERVICE_URL = 'http://pygments.appspot.com/';

    /**
     * Whether the web service should be used or not.
     *
     * @var bool
     */
    private $useService;

    /**
     * Constructor.
     * Initializes the state of the instance.
     */
    public function __construct()
    {
        $this->useService = !$this->binaryExists();
    }

    /**
     * Checks the existence of the pygments binary on the target system.
     *
     * @return bool
     */
    public function binaryExists()
    {
        $binaryExists = Command::create(self::PYGMENTS_BINARY_NAME)
            ->run()
            ->getExitCode() === 0;

        return $binaryExists;
    }

    /**
     * Highlight $code using Pygments, taking into account that it's written
     * in $language.
     * This method returns the HTML snippet for the pygmentized version of
     * $code.
     *
     * @param  string $language The language in which $code is written.
     * @param  string $code     The code to highlight.
     *
     * @return string
     */
    public function highlight($language, $code)
    {
        return $this->useService
            ? $this->runRemotely($language, $code)
            : $this->runLocally($language, $code);
    }

    /**
     * Get an Http Client.
     *
     * @return \Guzzle\Http\Client
     */
    protected function getHttpClient()
    {
        return new Client();
    }

    /**
     * Pygmentize $code using the remote service available at
     * {self::PYGMENTS_SERVICE_URL}.
     *
     * @param  string $language The language in which $code is written.
     * @param  string $code     The code to pygmentize.
     *
     * @return string
     */
    protected function runRemotely($language, $code)
    {
        $postBody = array(
            'lang' => $language,
            'code' => $code,
        );

        $response = $this->getHttpClient()
            ->post(self::PYGMENTS_SERVICE_URL, null, $postBody)
            ->send();

        return $response->getBody(true);
    }

    /**
     * Pygmentize $code using a local binary.
     *
     * @param  string $language The language in which $code is written.
     * @param  string $code     The code to pygmentize.
     *
     * @return string
     */
    protected function runLocally($language, $code)
    {
        $args = array(
            '-l' => $language,
            '-f' => 'html',
        );
        $opts = array('delimiter' => ' ');

        $response = Command::create(self::PYGMENTS_BINARY_NAME, $args, $opts)
            ->run($code)
            ->getOutput();

        return $response;
    }
}
