<?php
/**
 * Part of the Laradic packages.
 */
namespace Radic\BladeExtensions\Helpers;

use Illuminate\Contracts\View\Factory;

/**
 * Class Widget
 *
 * @package     Radic\BladeExtensions\Widgets
 * @author      Robin Radic
 * @license     MIT
 * @copyright   2011-2015, Robin Radic
 * @link        http://radic.mit-license.org
 */
class Sections
{

    /**
     * @var array
     */
    protected $sections = [];

    /**
     * @var array
     */
    protected $sectionStack = [];

    /**
     * @var \Illuminate\View\Factory
     */
    protected $factory;

    /**
     * Instantiates the class
     *
     * @param \Illuminate\View\Factory $factory
     */
    public function __construct(Factory $factory)
    {
        $this->factory = $factory;
    }

    /**
     * Start injecting content into a section.
     *
     * @param  string $section
     * @param  string $content
     * @return void
     */
    public function startSection($section, $content = '')
    {
        if ( $content === '' )
        {
            if ( ob_start() )
            {
                $this->sectionStack[] = $section;
            }
        }
        else
        {
            $this->extendSection($section, $content);
        }
    }

    /**
     * Inject inline content into a section.
     *
     * @param  string $section
     * @param  string $content
     * @return void
     */
    public function inject($section, $content)
    {
        $this->startSection($section, $content);
    }

    /**
     * Stop injecting content into a section and return its contents.
     *
     * @return string
     */
    public function yieldSection()
    {
        return $this->yieldContent($this->stopSection());
    }

    /**
     * Stop injecting content into a section.
     *
     * @param  bool $overwrite
     * @return string
     */
    public function stopSection($overwrite = false)
    {
        $last = array_pop($this->sectionStack);

        if ( $overwrite )
        {
            $this->sections[$last] = ob_get_clean();
        }
        else
        {
            $this->extendSection($last, ob_get_clean());
        }

        return $last;
    }

    /**
     * Stop injecting content into a section and append it.
     *
     * @return string
     */
    public function appendSection()
    {
        $last = array_pop($this->sectionStack);

        if ( isset($this->sections[$last]) )
        {
            $this->sections[$last] .= ob_get_clean();
        }
        else
        {
            $this->sections[$last] = ob_get_clean();
        }

        return $last;
    }

    /**
     * Append content to a given section.
     *
     * @param  string $section
     * @param  string $content
     * @return void
     */
    protected function extendSection($section, $content)
    {
        if ( isset($this->sections[$section]) )
        {
            $content = str_replace('@parent', $content, $this->sections[$section]);
        }

        $this->sections[$section] = $content;
    }

    /**
     * Get the string contents of a section.
     *
     * @param  string $section
     * @param  string $default
     * @return string
     */
    public function yieldContent($section, $default = '')
    {
        $sectionContent = $default;

        if ( isset($this->sections[$section]) )
        {
            $sectionContent = $this->sections[$section];
        }

        $sectionContent = str_replace('@@parent', '--parent--holder--', $sectionContent);

        return str_replace(
            '--parent--holder--', '@parent', str_replace('@parent', '', $sectionContent)
        );
    }

    /**
     * Flush all of the section contents.
     *
     * @return void
     */
    public function flushSections()
    {
        $this->sections = array();

        $this->sectionStack = array();
    }

    /**
     * Flush all of the section contents if done rendering.
     *
     * @return void
     */
    public function flushSectionsIfDoneRendering()
    {
        if ( $this->factory->doneRendering() )
        {
            $this->flushSections();
        }
    }

    /**
     * Get the entire array of sections.
     *
     * @return array
     */
    public function getSections()
    {
        return $this->sections;
    }
}
