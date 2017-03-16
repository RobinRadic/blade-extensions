<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright 2017 Robin Radic
 * @license   https://radic.mit-license.org MIT License
 * @version   7.0.0 Radic\BladeExtensions
 */

namespace Radic\BladeExtensions\Directives;

use Composer\Semver\Semver;

/**
 * This is the class Directive.
 *
 * @author  Robin Radic
 */
abstract class AbstractDirective implements DirectiveInterface
{
    /** @var string */
    protected $pattern = '/(?<!\\w)(\\s*)@NAME(\\s*)/';

    /** @var string The string to use for replacement */
    protected $replace;

    /** @var string The name to use */
    protected $name;

    /** @var string */
    public static $compatibility = '5.*';

    /**
     * isCompatibleWithVersion method.
     *
     * @param $version
     *
     * @return bool
     */
    public static function isCompatibleWithVersion($version)
    {
        return Semver::satisfies($version, static::$compatibility);
    }

    /**
     * isCompatible method.
     *
     * @return bool
     */
    public static function isCompatible()
    {
        return static::isCompatibleWithVersion(\Illuminate\Foundation\Application::VERSION);
    }

    /**
     * getProcessedPattern method.
     *
     * @return mixed
     */
    protected function getProcessedPattern()
    {
        return str_replace('NAME', $this->getName(), $this->getPattern());
    }

    /**
     * handle method
     *
     * @param $value
     *
     * @return mixed
     */
    public function handle($value)
    {
        return preg_replace($this->getProcessedPattern(), $this->getReplace(), $value);
    }

    /**
     * getPattern method
     *
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * setPattern method
     *
     * @param string $pattern
     *
     * @return $this
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * getReplace method
     *
     * @return string
     */
    public function getReplace()
    {
        return $this->replace;
    }

    /**
     * setReplace method
     *
     * @param string $replace
     *
     * @return $this
     */
    public function setReplace($replace)
    {
        $this->replace = $replace;

        return $this;
    }

    /**
     * getName method
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * setName method
     *
     * @param string $name
     *
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
