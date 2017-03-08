<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright 2017 Robin Radic
 * @license https://radic.mit-license.org MIT License
 * @version 7.0.0
 */
namespace Radic\BladeExtensions\Directives;

use Composer\Semver\Semver;

/**
 * This is the class Directive.
 *
 * @package Radic\BladeExtensions\Directives
 * @author  Robin Radic
 */
abstract class Directive
{
    /** @var string */
    protected $pattern = '/(?<!\\w)(\\s*)@NAME(\\s*)/';

    /** @var string. The string to use for replacement  */
    protected $replace;

    /** @var string. The name to use */
    protected $name;

    /** @var string. composer/ */
    public static $compatibility = '5.*';


    /**
     * isCompatibleWithVersion method
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
     * isCompatible method
     *
     * @return bool
     */
    public static function isCompatible()
    {
        return static::isCompatibleWithVersion(\Illuminate\Foundation\Application::VERSION);
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
     * getProcessedPattern method
     *
     * @return mixed
     */
    protected function getProcessedPattern()
    {
        return str_replace('NAME', $this->getName(), $this->getPattern());
    }

    /**
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * Set the pattern value.
     *
     * @param string $pattern
     *
     * @return Directive
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;

        return $this;
    }

    /**
     * @return string
     */
    public function getReplace()
    {
        return $this->replace;
    }

    /**
     * Set the replace value.
     *
     * @param string $replace
     *
     * @return Directive
     */
    public function setReplace($replace)
    {
        $this->replace = $replace;

        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the name value.
     *
     * @param string $name
     *
     * @return Directive
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }
}
