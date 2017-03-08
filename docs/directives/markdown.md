---
title: Markdown
subtitle: '@markdown'
---

#### Basic usage
Use the `@markdown` and `@endmarkdown` directives to render the markdown content.

```markdown
Somewhere in your view, you want to use markdown. Then you say
HEY!
@markdown
# And then start writing bbcode instead
**Cause thats gonna work***
@endmarkdown
```



### Minify CSS/JS
By default, only `@minify('html')` works. To enable javascript and css minification, add the `matthiasmullie/minify` package to your composer dependencies.
Blade Extensions automaticly detects the package and enables `@minify('js')` and `@minify('css')` directives. For more information, check out the directive's documentation page.
```json
"require": {
    "matthiasmullie/minify": "~1.3"
}
```

### Markdown
Add your preferred Markdown parser to your composer dependencies. By default `erusev/parsedown` is enabled as renderer. 
Check the markdown directive documentation page on how to implement custom a markdown parser.
```json
"require": {
    "erusev/parsedown": "~1.5"
}
```

### Debug output
The `@dump($var)` directive will either use Symfony's `VarDumper` or the regular `var_dump` method. 
