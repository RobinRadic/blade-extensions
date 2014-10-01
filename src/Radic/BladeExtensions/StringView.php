<?php namespace Radic\BladeExtensions;

use App, View, Closure, Config, ArrayAccess;
use Illuminate\Support\MessageBag;
use Illuminate\View\Engines\EngineInterface;
use Illuminate\Support\Contracts\MessageProviderInterface;
use Illuminate\Support\Contracts\ArrayableInterface as Arrayable;
use Illuminate\Support\Contracts\RenderableInterface as Renderable;
use Radic\BladeExtensions\Compilers\StringBladeCompiler;
use Illuminate\View\Engines\CompilerEngine;


class StringView extends \Illuminate\View\View implements ArrayAccess, Renderable {

    protected $template_field = 'template';

    public function __construct()
    {
        $cache = App::make('path.storage').'/views';
        $compiler = new StringBladeCompiler(App::make('files'), $cache);
        $this->engine = new CompilerEngine($compiler);
    }

    /**
     * Get a evaluated view contents for the given view.
     *
     * @param  mixed  $view
     * @param  array   $data
     * @param  array   $mergeData
     * @return \Illuminate\View\View
     */
    public function make($view, $data = array(), $mergeData = array())
    {

        // convert if array convert to object
        if (is_array($view)) {
            $view = json_decode(json_encode($view), FALSE);
        }

        /*
       *  validate the object
       */

        // timestamp for the compiled template cache
        // this needs to be updated if the actuall template data changed
        if( !isset($view->updated_at) )
        {
            throw new \Exception('Template last modified timestamp.');
        } else {
            if (!$this->is_timestamp($view->updated_at)) {
                throw new \Exception('Template last modified timestamp appears to be invalid.');
            }
            /*
           * Note: a timestamp of 0 translates to force recompile of the template.
           */
        }

        // this is the actually blade template data
        if( !isset($view->template) )
        {
            throw new \Exception('No template data was provided.');
        }

        // each template requires a unique cache key
        if( !isset($view->cache_key) )
        {
            throw new \Exception('Missing unique template cache string.');
        }

        $this->path = $view;
        $this->data = array_merge($mergeData, $this->parseData($data));

        return $this;
    }

    /**
     * Get the string contents of the view.
     *
     * @param  \Closure  $callback
     * @return string
     */
    public function render(Closure $callback = null)
    {
        $contents = $this->renderContents();

        $response = isset($callback) ? $callback($this, $contents) : null;

        // Once we have the contents of the view, we will flush the sections if we are
        // done rendering all views so that there is nothing left hanging over when
        // anothoer view is rendered in the future by the application developers.
        View::flushSectionsIfDoneRendering();

        return $response ?: $contents;
    }

    /**
     * Get the contents of the view instance.
     *
     * @return string
     */
    protected function renderContents()
    {
        // We will keep track of the amount of views being rendered so we can flush
        // the section after the complete rendering operation is done. This will
        // clear out the sections for any separate views that may be rendered.
        View::incrementRender();

        $contents = $this->getContents();

        // Once we've finished rendering the view, we'll decrement the render count
        // so that each sections get flushed out next time a view is created and
        // no old sections are staying around in the memory of an environment.
        View::decrementRender();

        return $contents;
    }

    protected function getContents()
    {
        /**
         * This property will be added to models being compiled with StringView
         * to keep track of which field in the model is being compiled
         */
        $this->path->__string_blade_compiler_template_field = $this->template_field;

        return parent::getContents();
    }

    /**
     * Parse the given data into a raw array.
     *
     * @param  mixed  $data
     * @return array
     */
    protected function parseData($data)
    {
        return $data instanceof Arrayable ? $data->toArray() : $data;
    }

    /**
     * Get the data bound to the view instance.
     *
     * @return array
     */
    protected function gatherData()
    {
        $data = array_merge(View::getShared(), $this->data);

        foreach ($data as $key => $value)
        {
            if ($value instanceof Renderable)
            {
                $data[$key] = $value->render();
            }
        }

        return $data;
    }

    /**
     * Add a view instance to the view data.
     *
     * @param  string  $key
     * @param  string  $view
     * @param  array   $data
     * @return \Illuminate\View\View
     */
    public function nest($key, $view, array $data = array())
    {
        return $this->with($key, View::make($view, $data));
    }

    /**
     * Determine if a piece of data is bound.
     *
     * @param  string  $key
     * @return bool
     */
    public function offsetExists($key)
    {
        return array_key_exists($key, $this->data);
    }

    /**
     * Get a piece of bound data to the view.
     *
     * @param  string  $key
     * @return mixed
     */
    public function offsetGet($key)
    {
        return $this->data[$key];
    }

    /**
     * Set a piece of data on the view.
     *
     * @param  string  $key
     * @param  mixed   $value
     * @return void
     */
    public function offsetSet($key, $value)
    {
        $this->with($key, $value);
    }

    /**
     * Unset a piece of data from the view.
     *
     * @param  string  $key
     * @return void
     */
    public function offsetUnset($key)
    {
        unset($this->data[$key]);
    }

    /**
     * Checks if a string is a valid timestamp.
     * from https://gist.github.com/sepehr/6351385
     *
     * @param string $timestamp Timestamp to validate.
     *
     * @return bool
     */
    public function is_timestamp($timestamp)
    {
        $check = (is_int($timestamp) OR is_float($timestamp))
            ? $timestamp
            : (string) (int) $timestamp;

        return ($check === $timestamp)
        AND ( (int) $timestamp <= PHP_INT_MAX)
        AND ( (int) $timestamp >= ~PHP_INT_MAX);
    }
}