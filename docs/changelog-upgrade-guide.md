---
title: Upgrade Guide & Changelog
---

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

