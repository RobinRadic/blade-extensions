<?php
/**
 * Created by IntelliJ IDEA.
 * User: radic
 * Date: 8/7/16
 * Time: 5:49 AM
 */

namespace Radic\BladeExtensions\Seven\Directives;


class DirectiveConfiguration
{
    protected $pattern;

    protected $replacement;

    /**
     * DirectiveConfiguration constructor.
     *
     * @param null|string $pattern     = null
     * @param null|string $replacement = null
     */
    public function __construct($pattern = null, $replacement = null)
    {
        $this->pattern     = $pattern;
        $this->replacement = $replacement;
    }


    public function hasPattern()
    {
        return null !== $this->pattern;
    }

    public function hasReplacement()
    {
        return null !== $this->replacement;
    }

    public function isConfigured()
    {
        return $this->hasPattern() || $this->hasReplacement();
    }

    /**
     * @return mixed
     */
    public function getPattern()
    {
        return $this->pattern;
    }


    /**
     * @return mixed
     */
    public function getReplacement()
    {
        return $this->replacement;
    }


}
