<?php

/*
 * This file is part of the Pinocchio library.
 *
 * (c) José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Pinocchio;


/**
 * Formatter for Pinocchio output files.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class Formatter
{
    /**
     * Configuration instance.
     *
     * @var \Pinocchio\Configuration
     */
    protected $configuration;

    /**
     * Constructor.
     *
     * @param \Pinocchio\Configuration $configuration The configuration instance.
     */
    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    /**
     * Format the given Pinocchio instance, optionally making an output
     * to $outputFile - if provided.
     * Returns the formatted code.
     *
     * @param \Pinocchio\Pinocchio $pinocchio  The Pinocchio instance to format.
     * @param string               $outputFile The path to an output file (optional).
     *
     * @return string
     */
    public function format(Pinocchio $pinocchio, $outputFile = null)
    {
        $annotatedSource = $this->apply($pinocchio);

        if (null !== $outputFile) {
            file_put_contents($outputFile, $annotatedSource);
        }

        return $annotatedSource;
    }

    /**
     * Apply the formatter to the given Pinocchio instance.
     * Returns the resulting HTML page.
     *
     * @param \Pinocchio\Pinocchio $pinocchio  The Pinocchio instance to format.
     *
     * @return string
     */
    protected function apply($pinocchio)
    {
        $variables = array(
            'configuration' => $this->configuration,
            'pinocchio'     => $pinocchio,
        );

        ob_start();

        extract($variables);
        include($this->configuration->get('template'));

        return ob_get_clean();
    }
}
