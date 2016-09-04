---
title: Upgrade Guide & Changelog
---

#### 6.2 > 7.0
- All the directives from 6.2 still work. 
- Completely revised code. If you have code that interacts with classes in `Radic\BladeExtensions`, it's highly likely it wont be working anymore.
- New config structure and filename. If you had any adjustments to the configuration, consider them                                                   
- [`NEW`] Added `@spaceless` and `@endspaceless`
- [`CHANGE`] Renamed `@debug` > `@dump`
- [`NEW`] Added `@debug`. Prints out local view variables in `$__env`. This is similar to [Smarty's `{debug}`](http://www.smarty.net/docs/en/language.function.debug.tpl)

#### 6.1 > 6.2
- Fixes the `blade.compiler` error by resolving the `BladeCompiler` differently
- Adds the `hasSection` to the `SectionsTrait` and `EmbedStack` to match the default `ViewFactory` 

#### 5.* > 6.0
-  Configuration file overhaul providing more customisation.
- `vendor:publish` the config file again to include the recent changed.
- `@embed` overhaul, check the documentation for details
- Renamed `@macro` to `@macrodef`. Renamed `@domacro` to `@macro`
- Dropped the `collective/html` requirement for `@macro` directives. 
- `@macro`, `@macrodef` and `@endmacro` are now available by default.
- New documentation generation method and updated/rewritten documentation


#### 4.* > 5.0
- The `@partial`, `@block` & `@render` directives are removed. Instead, use `@embed`.
- `vendor:publish` the config file again to include the recent changed.

