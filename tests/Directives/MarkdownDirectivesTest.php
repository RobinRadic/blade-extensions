<?php namespace Radic\Tests\BladeExtensions\Directives;

use Radic\Tests\BladeExtensions\TestCase;

/**
 * Class Markdown
 *
 * @author     Robin Radic
 * @group      blade-extensions
 */
class MarkdownDirectivesTest extends TestCase
{
    protected $renderedContent;
    public function setUp()
    {
        parent::setUp();
        $this->loadViewTesting();
        $this->registerBlade();
        $this->renderedContent = '';
    }

    protected function assertContent($needle)
    {
        $this->assertTrue(str_contains($this->renderedContent, $needle));
    }

    public function testMarkdown()
    {
        $this->renderedContent = $this->view()->make('markdown')->render();
        $this->assertContent('<h1>H1</h1>');
        $this->assertContent('<h2>H2</h2>');
        $this->assertContent('<h3>H3</h3>');
        $this->assertContent('<h4>H4</h4>');
        $this->assertContent('<h5>H5</h5>');
        $this->assertContent('<h6>H6</h6>');

        $this->assertContent('<h1>Alt-H1</h1>');
        $this->assertContent('<h2>Alt-H2</h2>');

        $this->assertContent('<p>Alternatively, for H1 and H2, an underline-ish style:</p>');
        $this->assertContent('<ol>');
        $this->assertContent('<li>First ordered list item</li>');
        $this->assertContent('</ol>');

        $this->assertTrue(true);
    }
}
