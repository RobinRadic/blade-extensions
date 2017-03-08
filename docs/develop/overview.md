---
title: Overview
subtitle: Develop
---

Development Overview
====================

## Application structure
All references are inside the `Radic\BladeExtensions` namespace.

| Reference                        | Description                                                                                                         |
|:---------------------------------|:--------------------------------------------------------------------------------------------------------------------|
| `BladeExtensions::class`         | Provides 'features': `compileString` and `pushToStack`                                                              |
| `DirectiveRegistry::class`       | Handles all the directives logic                                                                                    |
| `HelperRepository::class`        | Contains instances for some helpers                                                                                 |
| `Contracts\...`                  | Contracts for the `BladeExtensions`, `DirectiveRegistery` and `HelperRepository`. Should be prefered to use with DI |
| `Directives\...`                 | Contains all the core directive classes                                                                             |
| `Directives\Directive::class`    | Abstract base class for directives                                                                                  |
| `Helpers\...`                    | Contains helper classes that (are/can be) used by directives                                                        |
| `Exceptions\*::class`            | Exception classes                                                                                                   |
| `Facades\BladeExtensions::class` | The Facade that can be registered                                                                                   |


## Directives
- All directive classes need to extend the base class `Radic\BladeExtensions\Directives\Directive`.
- Core directive classes are located in `Radic\BladeExtensions\Directives`.
- Directive test classes usually extend the `Radic\Tests\BladeExtensions\DirectivesTestCase`
- Core directive test classes are located in `Radic\Tests\BladeExtensions\Directives`
- Directives and version overrides are added to the `DirectiveRegistry` by adding them to the `blade-extensions` configuration.
- The `DirectiveRegistry` contains the logic for handling the directives.

## Helpers
- Can be traits, interfaces or (abstract) classes ment to aid in a specific directive or multiple directives.
- The `HelperRepository` should be used for storing instances of helper classes. 


## Lifecycle
1. The `Radic\BladeExtensions\BladeExtensionsServiceProvider` binds `Radic\BladeExtensions\DirectiveRegistry`. 

2. When resolving the `DirectiveRegistry` the `blade-extensions` configuration is loaded into the registry.

  ```php
  $directives->register($app['config']['blade-extensions.directives']);
  $directives->setVersionOverrides($app['config']['blade-extensions.version_overrides']);
  ```

3. The `BladeExtensionsServiceProvider` adds a callback to `Application::booted` that executes `DirectiveRegistry@hookToCompiler()` 

4. The `hookToCompiler` method (by default) uses the `Illuminate\View\Compilers\BladeCompiler@extend` method, loops trough all directives and runs them using the `DirectiveRegistry->call($name, $params = [])` method.

  ```php
  // inside `Radic\BladeExtensions\DirectiveRegistry::hookToCompiler()` 
  foreach ($this->getNames() as $name) {
      $this->getCompiler()->extend(function ($value) use ($name) {
          return $this->call($name, [$value]);
      });
  }
  ```
  
5. The `DirectiveRegistry@call` method 'resolves' the directive if not already resolved, then calls it.
