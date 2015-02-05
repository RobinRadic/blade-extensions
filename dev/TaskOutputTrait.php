<?php

#require_once __DIR__ .'../vendor/phing/phing/classes/phing/Task.php';
require_once __DIR__ .'/../vendor/autoload.php';


use Symfony\Component\Console\Helper\ProgressBar;

trait TaskOutputTrait {

    protected $colors;

    protected function _style($args)
    {
        if(!isset($this->colors)){
            $this->colors = new RadicColors();
        }
        return count($args) > 1 ? $this->colors->apply(array_slice($args, 1), $args[0]) : $args[0];
    }

    public function str()
    {
        print($this->_style(func_get_args()));
    }

    public function ln()
    {
        print($this->_style(func_get_args()));
        $this->br();
    }

    public function br()
    {
        print("\n");
    }

    public function dump($val){
        //array_map(function($x) { (new Dumper)->dump($x); }, [$val]);
    }
}
