<?php namespace Radic\BladeExtensions\Compilers;

use Config;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Compilers\CompilerInterface;

class StringBladeCompiler extends BladeCompiler implements CompilerInterface {

    /**
     * Compile the view at the given path.
     *
     * @param  Illuminate\Database\Eloquent\Model  $path
     * @return void
     */
    public function compile($path)
    {

        // get the template data
        $string = $path->template;

        // Compile to PHP
        $contents = $this->compileString($string);

        // check/save cache
        if ( ! is_null($this->cachePath))
        {
            $this->files->put($this->getCompiledPath($path), $contents);
        }
    }

    /**
     * Get the path to the compiled version of a view.
     *
     * @param  Illuminate\Database\Eloquent\Model  $model
     * @return string
     */
    public function getCompiledPath($model)
    {
        /*
         * A unique path for the given model instance must be generated
         * so the view has a place to cache. The following generates a
         * path using almost the same logic as Blueprint::createIndexName()
         */
        return $this->cachePath.'/'.md5($model->cache_key);
    }

    /**
     * Determine if the view at the given path is expired.
     *
     * @param  string  $path
     * @return bool
     */
    public function isExpired($path)
    {
        $compiled = $this->getCompiledPath($path);

        // If the compiled file doesn't exist we will indicate that the view is expired
        // so that it can be re-compiled. Else, we will verify the last modification
        // of the views is less than the modification times of the compiled views.
        if ( ! $this->cachePath || ! $this->files->exists($compiled))
        {
            return true;
        }

        // 0 timestamp for last updated is treated as force tempalte compile update
        if ($path->updated_at == 0) {
            $path->updated_at = $this->files->lastModified($compiled)+1;
        }

        $lastModified = $path->updated_at;

        // if ( $lastModified >= $this->files->lastModified($compiled) )
        // echo $lastModified . ' ('.date('r', $lastModified).') > ' . $this->files->lastModified($compiled) . ' ('.date('r', $this->files->lastModified($compiled)).')<br/>';

        return $lastModified >= $this->files->lastModified($compiled);
    }
}