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

use \Clinner\ValueHolder;


/**
 * Configuration handler for Pinocchio.
 * Implements a cascading mechanism for configuring Pinocchio.
 * The precedence order is:
 *
 * 1. Arguments provided.
 * 2. Configuration file (if any).
 * 3. Default values.
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class Configuration
{
    const CONFIGURATION_FILENAME = 'pinocchio.json';

    /**
     * Arguments value holder.
     *
     * @var \Clinner\ValueHolder
     */
    protected $arguments;

    /**
     * Configuration value holder.
     *
     * @var \Clinner\ValueHolder
     */
    protected $configuration;

    /**
     * Defaults value holder.
     *
     * @var \Clinner\ValueHolder
     */
    protected $defaults;

    /**
     * Pinocchio array of sources.
     * This attribute acts as a simple cache.
     *
     * @var array
     */
    protected $sources;

    /**
     * Constructor.
     *
     * @param array|\Clinner\ValueHolder $arguments (Optional) Arguments for the configuration.
     *                                              If not provided, these will be acquired
     *                                              via `getopt()`.
     */
    public function __construct($arguments = null)
    {
        if (null === $arguments) {
            $arguments = getopt('', array('source:', 'output:', 'silent', 'logger:', 'logger_opts:'));

            // Nasty workaround for `getopt()`'s denial to treat correctly flag options o_O
            if (isset($arguments['silent'])) {
                $arguments['silent'] = true;
            }
        }

        $this
            ->setArguments($arguments)
            ->initialize();
    }

    /**
     * Get the value for $key.
     *
     * @param  string $key The configuration key.
     *
     * @return mixed
     */
    public function get($key)
    {
        $value = $this->arguments->get($key);

        if (null === $value) {
            $value = $this->configuration->get($key);

            if (null === $value) {
                $value = $this->defaults->get($key);
            }
        }

        return $value;
    }

    /**
     * Get the source files as an associative array.
     *
     * @return array
     */
    public function getSourceFiles()
    {
        $sourceFiles = array();
        $ignore = $this->configuration->get('ignore');

        if (is_dir($this->get('source'))) {
            $recursiveIterator = new \RecursiveIteratorIterator(
                new \RecursiveDirectoryIterator($this->get('source'))
            );

            foreach ($recursiveIterator as $file) {
                if (!$ignore || !preg_match($ignore, $file->getPathname())) {
                    $sourceFiles[$file->getFilename()] = $file->getPathname();
                }
            }
        }

        return $sourceFiles;
    }

    /**
     * Get the set of source Pinocchios that represent the source files
     * for the current instance.
     *
     * @return array
     */
    public function getSources()
    {
        if (null === $this->sources) {
            $sources = array();

            foreach ($this->getSourceFiles() as $sourcePath) {
                $sources[] = new Pinocchio($sourcePath);
            }

            $this->sources = $sources;
        }

        return $this->sources;
    }

    /**
     * Set the arguments.
     *
     * @param  array|\Clinner\ValueHolder $arguments The new arguments
     *
     * @return \Pinocchio\Configuration
     */
    public function setArguments($arguments)
    {
        $this->arguments = new ValueHolder($arguments);

        return $this;
    }

    /**
     * Get the default value for the configuration.
     *
     * @return array
     */
    public function getDefaults()
    {
        return array(
            'source'          => 'src',
            'output'          => 'doc',
            'template'        => __DIR__ . '/templates/template.php',
            'css'             => array(__DIR__ . '/templates/styles.css'),
            'ignore'          => '/^\./',
            'skip_index'      => false,
            'index_template'  => __DIR__ . '/templates/index.php',
            'index_title'     => 'Source files',
        );
    }

    /**
     * Initialize the non-customizable part of the configuration.
     *
     * @return \Pinocchio\Configuration
     */
    protected function initialize()
    {
        $this->configuration = new ValueHolder($this->loadConfiguration());
        $this->defaults = new ValueHolder($this->getDefaults());

        return $this;
    }

    /**
     * Load the configuration from the file -if any- and return it.
     *
     * @return array
     */
    protected function loadConfiguration()
    {
        $configuration = null;

        if (file_exists(self::CONFIGURATION_FILENAME)) {
            $configuration = json_decode(file_get_contents(self::CONFIGURATION_FILENAME), true);
        }

        return $configuration ?: array();
    }
}
