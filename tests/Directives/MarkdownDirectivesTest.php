<?php namespace Radic\Tests\BladeExtensions\Directives;

use Radic\BladeExtensions\Directives\MarkdownDirectives;
use Radic\Tests\BladeExtensions\TestCase;

/**
 * Class Markdown
 *
 * @author     Robin Radic
 * @group blade-extensions
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
        if ($exists === true) {
            MarkdownDirectives::attach($this->app);
            $this->view()->make('markdown')->render();
        }
        $this->assertTrue(true);
    }
}
