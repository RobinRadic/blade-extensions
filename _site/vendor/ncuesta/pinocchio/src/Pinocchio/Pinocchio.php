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
 * Pinocchio
 *
 * @author José Nahuel Cuesta Luengo <nahuelcuestaluengo@gmail.com>
 */
class Pinocchio
{
    /**
     * The path to the source file represented by this object.
     *
     * @var string
     */
    protected $path;

    /**
     * The source code.
     * This attribute acts as a simple cache.
     *
     * @var string
     */
    protected $source;

    /**
     * Code blocks in the file represented by this object.
     *
     * @var array
     */
    protected $codeBlocks;

    /**
     * Documentation blocks in the file represented by this object.
     *
     * @var array
     */
    protected $docBlocks;

    /**
     * Constructor.
     *
     * @param string $path The path to the source file.
     */
    public function __construct($path)
    {
        $this
            ->setPath($path)
            ->setCodeBlocks(array())
            ->setDocBlocks(array());
    }

    /**
     * Set the path to the source file.
     *
     * @param  string $path The path to the source file.
     *
     * @return \Pinocchio\Pinocchio
     *
     * @throws \InvalidArgumentException If $path is not a readable file.
     */
    public function setPath($path)
    {
        if (!is_readable($path)) {
            throw new \InvalidArgumentException('The passed path is not readable: ' . $path);
        }

        $this->path = $path;
        $this->source = file_get_contents($path);

        return $this;
    }

    /**
     * Get the path to the source file.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get the source code.
     *
     * @return string
     */
    public function getSource()
    {
        return $this->source;
    }

    /**
     * Get the code blocks.
     *
     * @return array
     */
    public function getCodeBlocks()
    {
        return $this->codeBlocks;
    }

    /**
     * Set the code blocks.
     *
     * @param array $codeBlocks The new code blocks.
     *
     * @return \Pinocchio\Pinocchio
     */
    public function setCodeBlocks($codeBlocks)
    {
        $this->codeBlocks = $codeBlocks;

        return $this;
    }

    /**
     * Get a code block at a specific offset.
     *
     * @param  int $index The offset to get.
     *
     * @return string
     */
    public function getCodeBlock($index)
    {
        return isset($this->codeBlocks[$index]) ? $this->codeBlocks[$index] : '';
    }

    /**
     * Get the documentation blocks.
     *
     * @return array
     */
    public function getDocBlocks()
    {
        return $this->docBlocks;
    }

    /**
     * Get a documentation block at a specific offset.
     *
     * @param  int $index The offset to get.
     *
     * @return string
     */
    public function getDocBlock($index)
    {
        return isset($this->docBlocks[$index]) ? $this->docBlocks[$index] : '';
    }

    /**
     * Set the documentation blocks.
     *
     * @param array $docBlocks
     *
     * @return \Pinocchio\Pinocchio
     */
    public function setDocBlocks($docBlocks)
    {
        $this->docBlocks = $docBlocks;

        return $this;
    }

    /**
     * Add a code block to this object.
     *
     * @param  string $codeBlock The code block to add.
     *
     * @return \Pinocchio\Pinocchio
     */
    public function addCodeBlock($codeBlock)
    {
        $this->codeBlocks[] = $codeBlock;

        return $this;
    }

    /**
     * Add a documentation block to this object.
     *
     * @param  string $docBlock The documentation block to add.
     *
     * @return \Pinocchio\Pinocchio
     */
    public function addDocBlock($docBlock)
    {
        $this->docBlocks[] = $docBlock;

        return $this;
    }

    /**
     * Get an `SplFileInfo` instance representing the file of this object.
     *
     * @return \SplFileInfo
     */
    public function getFileInformation()
    {
        return new \SplFileInfo($this->getPath());
    }

    /**
     * Get the name for this Pinocchio's output file.
     *
     * @param  string $prefix Prefix to remove from the filename (optional).
     *
     * @return string
     */
    public function getOutputFilename($prefix = null)
    {
        $fileInfo = $this->getFileInformation();
        $filename = str_replace('/', '_', $fileInfo->getPathname());

        if (null !== $prefix) {
            $filename = substr($filename, strlen($prefix));
        }

        return strtr(ltrim($filename, '_'), array('.' . $fileInfo->getExtension() => '.html'));
    }

    /**
     * Get the title of this Pinocchio.
     *
     * @return string
     */
    public function getTitle()
    {
        $fileInfo = $this->getFileInformation();

        return $fileInfo->getBasename('.' . $fileInfo->getExtension());
    }
}
