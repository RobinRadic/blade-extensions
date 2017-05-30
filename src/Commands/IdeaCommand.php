<?php
/**
 * Copyright (c) 2017. Robin Radic.
 *
 * The license can be found in the package and online at https://radic.mit-license.org.
 *
 * @copyright 2017 Robin Radic
 * @license   https://radic.mit-license.org MIT License
 * @version   7.0.0 Radic\BladeExtensions
 */

namespace Radic\BladeExtensions\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class IdeaCommand extends Command
{
    protected $signature = 'blade:idea';

    protected $description = '';

    /** @var Filesystem */
    protected $fs;

    public function handle()
    {
        $this->fs   = new Filesystem;
        $ideaPath   = base_path('.idea');
        $targetPath = $ideaPath . '/blade.xml';
        $sourcePath = __DIR__ . '/blade.default.xml';

        if (false === $this->fs->isDirectory($ideaPath)) {
            /** @noinspection PhpVoidFunctionResultUsedInspection */
            return $this->error('Could not find the project\'s .idea directory.');
        }

        if (false === $this->fs->isFile($targetPath)) {
            if ($this->confirm('No existing blade configuration file found. Shall i create it for you?', false)) {
                $this->fs->copy($sourcePath, $targetPath);
            } else {
                /** @noinspection PhpVoidFunctionResultUsedInspection */
                return $this->warn('Operation canceled. No blade configuration has been created.');
            }
        }
        $this->alterConfiguration(__DIR__ . '/blade.test.xml');
//        if ($this->confirm('Going to alter the blade configuration file. Are you sure?', false)) {}
    }

    protected function alterConfiguration($filePath)
    {
        $fileContent = $this->fs->get($filePath);
        $el          = simplexml_load_string($fileContent);
        $directives  = $el->xpath('/project/component/customDirectives')[0];

        $directive = $directives->addChild('dat2a');
        $directive->addAttribute('directive', '@unset');
        $directive->addAttribute('prefix', html_entity_decode('<?php unset('));
        $directive->addAttribute('suffix', html_entity_decode('); ?>'));



        $a = 'a';

    }


}
