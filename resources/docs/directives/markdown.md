<!---
title: Markdown
author: Robin Radic
-->

#### Inline
You can render markdown text using
```php
@markdown
# Header

- list item
- list item 2
 
[My link](https://mylink.com)
@endmarkdown
```


#### Including
If you enable the views option in the configuration file, you can also include .md files using
```php
@include('my_markdown_file') # includes and renders my_markdown_file.md 
```

