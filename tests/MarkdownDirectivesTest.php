<?php namespace Radic\BladeExtensionsTests;

use Radic\BladeExtensions\Directives\MarkdownDirective;

/**
 * Class Markdown
 *
 * @author     Robin Radic
 *
 */
class MarkdownDirectivesTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->loadViewTesting();
        $this->registerBlade();
    }

    public function testMarkdown()
    {
        $exists = class_exists('Parsedown');
        if ($exists === true)
        {
            MarkdownDirective::attach($this->app);
            $this->view->make('markdown')->render();
        }
    }
}
