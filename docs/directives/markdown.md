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

#### Using the views
If you have the config option `markdown.views` enabled, you can import markdown files using the `@include` directive.

You can load `.md`, `.md.blade.php` and `.md.php` files directly into your views. 
By using the `blade` or `php` extension, you can also use those languages.

```php
// Some fancy markdown document is located at markdown/file/path.md
View::make('markdown/file/path')->render();
```

Will work just as well.
