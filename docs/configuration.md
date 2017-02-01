---
title: Configuration
---
# Configuration

#### Blacklisting directives
Blacklisting a directive allows you to disable unwanted directives. For a full list of directives, check the [directives.php](https://github.com/RobinRadic/blade-extensions/blob/master/src/directives.php) file.
```php
return array(
    'blacklist' => array('set', 'unset', 'markdown', 'endmarkdown')
);
```


#### Overriding directives
Blade Extensions allows you to override any directive using the `overrides` key. For reference you can use the [directives.php](https://github.com/RobinRadic/blade-extensions/blob/master/src/directives.php) file. An example:
```php
return array(
    'overrides' => array(
        'break'      => array(
            'pattern'     => '/(?<!\\w)(\\s*)@break(\\s*)/',
            'replacement' => '$1<?php break; ?>$2'
        )
    )
);
```


#### Example views
If enabled, several example views including layout, views and embed partials will be available under the blade-ext::<view> namespace. 
Use `vendor:publish` to publish to your own resources folder. Based on bootstrap 3.3
```php
return array(
    'example_views' => true
);
```
```sh
php artisan vendor:publish --provider=Radic\BladeExtensions\BladeExtensionsServiceProvider --tag=view
```


#### Markdown
The markdown configuration allows you to define a custom markdown renderer or enable the markdown view engine. 
More information can be found on the Markdown directive documentation page. 
```php
return array(
    'markdown'  => array(
        /*
        |---------------------------------------------------------------------
        | Enable markdown directives
        |---------------------------------------------------------------------
        |
        */
        'enabled'  => true,
        /*
        |---------------------------------------------------------------------
        | Markdown renderer class
        |---------------------------------------------------------------------
        |
        | Class that renders markdown. Needs to implement Radic\BladeExtensions\Contracts\MarkdownRenderer
        |
        */
        'renderer' => 'Radic\BladeExtensions\Renderers\ParsedownRenderer',
        /*
        |---------------------------------------------------------------------
        | Enable view compiler
        |---------------------------------------------------------------------
        |
        | Enables markdown view compiler.
        | This will enable you to use View::make('my_markdown_file') on `my_markdown_file.md`.
        | Or use @include('my_markdown_file')
        |
        */
        'views'    => false
    )
);
```
