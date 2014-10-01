<?php

use Mockery as m;
use Radic\BladeExtensions\BladeExtensionsServiceProvider;
use Radic\BladeExtensions\Core\LoopStackInterface;
use Radic\BladeExtensions\Extensions\ForEachManager;
use Radic\BladeExtensions\Extensions\ForEachStatement;


class ForeachViewTest extends Orchestra\Testbench\TestCase
{
    protected $data;

    public function setUp()
    {
        parent::setUp();
        $this->app->register(new BladeExtensionsServiceProvider($this->app));
        $this->data = json_decode(\File::get(__DIR__ . '/data.json'), true);
        View::addLocation(__DIR__.'/views');
    }


    public function testForeachSetCount()
    {
       $view = View::make('foreach-set-count', ['loopData' => $this->data, 'testNumber' => 10, 'count' => 5]);
       $this->assertTrue((int) $view->render() == 135);

    }

    public function testForeachSetCount2()
    {
        $view = View::make('foreach-set-count2', ['loopData' => $this->data, 'count' => 0]);
        $this->assertTrue((int) $view->render() == 78);
    }

    public function testForeachNested()
    {
        $input = ['loopData' => $this->data, 'count' => 0];
        $view = View::make('foreach-nested', $input);
        $output = $view->render();
        foreach(explode(PHP_EOL, $output) as $line)
        {
            $outer = new ForEachStatement();
            foreach($input['loopData'] as $index => $data)
            {
                $inner = new ForEachStatement();
                foreach($input['loopData'] as $index2 => $data2)
                {

                }
                unset($inner);
            }
            unset($outer);
        }
        #$this->assertTrue((int) $view->render() == 78);
    }


}