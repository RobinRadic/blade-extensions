# Pinocchio

[![Build Status](https://secure.travis-ci.org/ncuesta/pinocchio.png?branch=master)](http://travis-ci.org/ncuesta/pinocchio)

Annotated Source generator for PHP (port of [Docco](http://jashkenas.github.com/docco)). This library has been
inspired by [Phrocco](https://github.com/oneblackbear/phrocco).

**Pinocchio** crawls the source files on a project and automatically generates
annotated source HTML pages that serve both as self-documented projects and
API-like documentation.

You may see the [annotated source of **Pinnochio**](http://ncuesta.github.com/pinocchio/docs/index.html), for an example.

## Key benefits

* Easy to use
* Almost no requirements (only PHP >= 5.3.6)
* Configurable and customizable
* Makes projects self-documented

## Installation

You can install **Pinocchio** using [Composer](http://getcomposer.org). It is
more likely that you'll use **Pinocchio** as a development library and not as
one that will actually be required for the use of your project, so you might
want to use it as a `dev` requirement in your `composer.json` file like this:

```json
{
    "require-dev": {
        "ncuesta/pinocchio": "dev-master"
    }
}
```

Once you have that, you can `install` it providing the `--dev` flag:

```bash
$ composer install --dev
```

If Composer complains about stability issues, you might need to add a `minimum-stability`
key to the `composer.json` file like follows:

```json
{
    "require-dev": {
        "ncuesta/pinocchio": "dev-master"
    },
    "minimum-stability": "dev"
}
```

## Usage

Once installed via [Composer](http://getcomposer.org) you can use **Pinocchio**
directly from the command-line interface as follows. Please note that
`vendor/bin/pinocchio` is the path to **Pinocchio**'s executable, and that
`vendor/bin` is the directory in which [Composer](http://getcomposer.org)
installs any vendor binary files by default. If you have changed this path,
be sure that you are running **Pinocchio** from your specific one.

So, running:

```bash
$ php vendor/bin/pinocchio
```

will crawl for any source files under `./src` directory and will generate their corresponding annotated source files under `./output`. See below for further
customization of this behavior.

## Configuration

**Pinocchio** can be configured in many ways. You can provide your configuration
options when running the script, have your settings taken from a configuration
file located on the root of your project, or a combination of both.

The order in which option sources are considered is:

1. Command-line arguments
2. Configuration file values
3. Default values

### Configuration options

Here is a list of all the configuration options and their acceptable values:

* `source` (`string`): The path to the source directory to crawl
  for sources.
* `output` (`string`): The path to the output directory in which generated
  files will be saved.
* `template` (`string`): The path to the template to use for each source
  file.
* `css` (`array`): A set of CSS files to use inside the template.
* `ignore` (`string`): A regular expression that if matched by any path
  inside the `source` directory, will exclude such path from the crawled files.
* `silent` (`boolean`): A value indicating whether the logger should be silent
  or output things.
* `logger` (`string`): A fully-qualified class name to use as Logger class.
  This class _should_ implement `\Pinocchio\Logger\LoggerInterface`.
* `logger_opts` (`array`): A set of options that will be provided to the Logger
  upon its initialization. Note that the default Logger class does not take any
  option into account.
* `skip_index` (`boolean`): If `true`, no index file will be generated. Otherwise,
  an `index.html` file will be created at the `output` directory with links to the
  different files, as presented in the `index_template` template.
* `index_template` (`string`): The path to the template to use for the index file.
  Only applicable when `skip_index` is `true`.
* `index_title` (`string`): The title to add to the index file.

### Configuration as arguments

When running **Pinocchio** you can pass arguments that will be considered as
configuration options. For instance:

```bash
$ php vendor/bin/pinocchio --source src --output annotated-source
```

Will tell **Pinocchio** that the `source` option has been set to `src` and
`output` to `annotated-source`.

### Configuration file

If a file named `pinocchio.json` is found at the directory in which you invoke
**Pinocchio** (namely your project's root), it will be used as an configuration
source. For instance:

```json
{
    "source":   "lib",
    "output":   "doc",
    "template": "path/to/some/template.php",
    "css":      ["stylesheet_1.css", "path/to/stylesheet_2.css"],
    "ignore":   "/ignore\s+me\s+regex/i",
    "silent":   true
}
```

### Default values

All configuration values have a sensible default value so that you *don't have to*
configure anything. Here is a list of all the default values for the different
configuration options:

* `source`: `'src'`.
* `output`: `'output'`.
* `template`: A built-in template based on [Docco](http://jashkenas.github.com/docco)'s template.
* `css`: A built-in stylesheet based on [Docco](http://jashkenas.github.com/docco)'s stylesheet.
* `ignore`: `'/^\./'`. Dot-files are ignored by default.
* `silent`: `false`. Everything is logged by default. Don't worry, it's not *that* verbose.
* `logger`: `'\Pinocchio\Logger\StandardLogger'`. Default class, you can specify a fully-qualified
  one if you want. Please note that it should implement `\Pinocchio\Logger\LoggerInterface`.
* `logger_opts`: `[]` (an empty array). No options are provided to the logger by default.
* `skip_index`: `false`.
* `index_template`: A built-in template that simply links to every parsed source file.
* `index_title`: `'Source files'`.

## Contributing

**Pinocchio** is an Open Source project and hence any collaborations, suggestions or whatsoever
are welcome. For any of those matters, please use the [Issues](https://github.com/ncuesta/pinocchio/issues)
or create Pull Requests.

## License

**Pinocchio** is licensed under the **MIT** License. Here you have the boring
legal stuff:

```
Copyright (c) 2012 José Nahuel Cuesta Luengo

Permission is hereby granted, free of charge, to any person obtaining a copy of
this software and associated documentation files (the "Software"), to deal in
the Software without restriction, including without limitation the rights to
use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
the Software, and to permit persons to whom the Software is furnished to do so,
subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS
OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
```
