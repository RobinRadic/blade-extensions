<?php namespace Radic\Tests\BladeExtensions\Renderers;

use Mockery as m;
use Radic\BladeExtensions\Renderers\BladeStringRenderer;
use Radic\Tests\BladeExtensions\TestCase;

class BladeStringRendererRendererTest extends TestCase
{
    /**
     * @var \Mockery\MockInterface
     */
    protected $bc;

    /**
     * @var \Radic\BladeExtensions\Renderers\BladeStringRenderer
     */
    protected $bs;

    /**
     * @var \Mockery\MockInterface
     */
    protected $fs;

    public function testRender()
    {
        $bs = $this->bs;
        $bs->setTmpFilePath(__DIR__ . '/bladestring_render_include.php');

        $this->fs->shouldReceive('put')->andReturn();
        $this->bc->shouldReceive('compileString')->andReturn('');
        $this->fs->shouldReceive('delete')->andReturn();
        $this->assertStringStartsWith('thisispath', $bs->render('', ['var1' => 'val1']));

    }

    /**
     * @inheritDoc
     */
    protected function start()
    {
        $this->bs = new BladeStringRenderer(
            $this->bc = m::mock('Illuminate\\View\\Compilers\\BladeCompiler'),
            $this->fs = m::mock('Illuminate\\Filesystem\\Filesystem')
        );
    }

    public function testGettersSetters()
    {
        $bs = $this->bs;
        $bs->setFiles($this->fs);
        $bs->setTmpFilePath(__DIR__);

        $this->assertInstanceOf('Illuminate\\Contracts\\Filesystem\\Filesystem', $bs->getFiles());
        $this->assertEquals(__DIR__, $bs->getTmpFilePath());
    }
}
