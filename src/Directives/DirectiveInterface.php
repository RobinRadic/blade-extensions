<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright 2017 Robin Radic
 * @license https://radic.mit-license.org MIT License
 * @version 7.0.0 Radic\BladeExtensions
 */

namespace Radic\BladeExtensions\Directives;

/**
 * Interface DirectiveInterface.
 *
 * @author  Robin Radic
 */
interface DirectiveInterface
{
    /**
     * Checks if the directive is compatible with the current Laravel version.
     *
     * @return bool
     */
    public static function isCompatible();

    /**
     * handle method.
     *
     * @param $value
     *
     * @return mixed
     */
    public function handle($value);

    /**
     * @return string
     */
    public function getPattern();

    /**
     * Set the pattern value.
     *
     * @param string $pattern
     *
     * @return AbstractDirective
     */
    public function setPattern($pattern);

    /**
     * @return string
     */
    public function getReplace();

    /**
     * Set the replace value.
     *
     * @param string $replace
     *
     * @return AbstractDirective
     */
    public function setReplace($replace);

    /**
     * @return string
     */
    public function getName();

    /**
     * Set the name value.
     *
     * @param string $name
     *
     * @return AbstractDirective
     */
    public function setName($name);
}
