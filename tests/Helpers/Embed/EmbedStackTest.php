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

namespace Radic\Tests\BladeExtensions\Helpers\Embed;

use Mockery as m;
use Radic\BladeExtensions\Helpers\Embed\EmbedStack;
use Radic\Tests\BladeExtensions\TestCase;

class EmbedStackTest extends TestCase
{
    /**
     * @var \Mockery\MockInterface
     */
    protected $vf;

    /**
     * @var \Mockery\MockInterface
     */
    protected $fs;

    /**
     * @var \Mockery\MockInterface
     */
    protected $bc;

    /**
     * @var \Radic\BladeExtensions\Helpers\EmbedStack
     */
    protected $stack;

    public function testMakeStack()
    {
        /**
         * @var \Radic\BladeExtensions\Helpers\EmbedStack
         */
        $stack = $this->stack->start();
        $this->assertEquals($stack, $this->stack);

        // little trick to set the include($path) to the file we want in stack::end
        $stack->setData(['path' => __DIR__.'/embed_stack_include.php', 'sf' => 'mmo']);

        $content = <<<EOT
@section("one", "oneval")
@section("two", "twoval")
EOT;
        $contentCompiled = <<<'EOT'
<?php $__env->startSection("one", "oneval"); ?>
<?php $__env->startSection("two", "twoval"); ?>
EOT;

        $viewContent = <<<'EOT'
1:@yield('one')
2:@yield('two')
EOT;
        $viewContentCompiled = <<<'EOT'
1:oneval
2:twoval
EOT;
        $stack->setContent($content);
        $this->bc->shouldReceive('compileString')->with(m::mustBe($content))->andReturn($contentCompiled);
        $this->vf->shouldReceive('getFinder')->andReturn($finder = m::mock('Illuminate\\View\\ViewFinderInterface'));
        $absoluteViewPath = realpath(__DIR__.'/../views/embed.blade.php');
        $finder->shouldReceive('find')->andReturn($absoluteViewPath);
        $this->fs->shouldReceive('get')->with(m::mustBe($absoluteViewPath))->andReturn($viewContent);
        $this->bc->shouldReceive('compileString')->with(m::mustBe($viewContent))->andReturn($viewContentCompiled);
        $this->fs->shouldReceive('exists')->andReturn(true);
        $this->fs->shouldReceive('put')->andReturn(); //->andSet()andReturn(['name', __DIR__ . '/embed_stack_include.php']);
        $this->fs->shouldReceive('delete')->andReturn();
        $this->stack->end();
        $output = 'thisispath
';
        $this->expectOutputString($output);
        //fwrite(STDERR, print_r($end, TRUE));
    }

    protected function start()
    {
        $this->stack = new EmbedStack(
            $this->vf = m::mock('Illuminate\Contracts\View\Factory'),
            $this->fs = m::mock('Illuminate\Filesystem\Filesystem'),
            $this->bc = m::mock('Illuminate\View\Compilers\BladeCompiler'),
            $viewPath = 'embed',
            $vars = ['var1' => 'val1', 'var2', 'val2']
        );
    }
}
