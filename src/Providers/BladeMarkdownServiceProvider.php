<?php
namespace Radic\BladeExtensions\Providers;


use Illuminate\Contracts\Foundation\Application;

class BladeMarkdownServiceProvider extends BladeServiceProvider
{
    protected function booting(Application $app)
    {
        MarkdownDirectives::attach($app);
    }

    public function register()
    {
        $app = parent::register();


        # Optional markdown compiler, engines and directives
        if ( !class_exists($this->config('markdown.renderer')) ) {
            throw new Exception('The configured markdown renderer class does not exist');
        }

        $app->bind('Radic\BladeExtensions\Contracts\MarkdownRenderer', $this->config('markdown.renderer'));

        $app->singleton('markdown', function (Application $app) {
            return $app['Radic\BladeExtensions\Contracts\MarkdownRenderer'];
        });

        $app->singleton('markdown.compiler', function (Application $app) {
            $markdownRenderer = $app->make('markdown');
            $files            = $app->make('files');
            $storagePath      = $app[ 'config' ]->get('view.compiled');
            return new MarkdownCompiler($markdownRenderer, $files, $storagePath);
        });
    }


}
