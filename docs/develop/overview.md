---
title: Overview
subtitle: Develop
---

Development Overview
====================

## Application structure
All references are inside the `Radic\BladeExtensions` namespace.

| Reference                              | Description                                                                                                         |
|:---------------------------------------|:--------------------------------------------------------------------------------------------------------------------|
| `BladeExtensions::class`               | Provides 'features': `compileString` and `pushToStack`                                                              |
| `DirectiveRegistry::class`             | Handles all the directives logic                                                                                    |
| `HelperRepository::class`              | Contains instances for some helpers                                                                                 |
| `Contracts\...`                        | Contracts for the `BladeExtensions`, `DirectiveRegistery` and `HelperRepository`. Should be prefered to use with DI |
| `Directives\...`                       | Contains all the core directive classes                                                                             |
| `Directives\DirectiveInterface::class` | Interface for directives                                                                                            |
| `Directives\AbstractDirective::class`  | Optional abstract class for directives                                                                         |
| `Helpers\...`                          | Contains helper classes that (are/can be) used by directives                                                        |
| `Exceptions\*::class`                  | Exception classes                                                                                                   |
| `Facades\BladeExtensions::class`       | The Facade that can be registered                                                                                   |


## Directives
- All directive classes need to implement the interface `Radic\BladeExtensions\Directives\DirectiveInterface`. 
  In most cases, using the abstract class `Radic\BladeExtensions\Directives\AbstractDirective` is faster.
- Core directive classes are located in `Radic\BladeExtensions\Directives`.
- Core directive test classes are located in `Radic\Tests\BladeExtensions\Directives`
- Directive test classes usually extend the `Radic\Tests\BladeExtensions\DirectivesTestCase`.
- The `DirectiveRegistry` contains the directives and the logic for handling them.
- Directives and version overrides are added to the `DirectiveRegistry` by adding them to the `blade-extensions` configuration.

## Helpers
- Can be traits, interfaces or (abstract) classes ment to aid in a specific directive or multiple directives.
- The `HelperRepository` is used for storing instances of helper classes. 


## Lifecycle
<strong>1.</strong> The `Radic\BladeExtensions\BladeExtensionsServiceProvider` binds `Radic\BladeExtensions\DirectiveRegistry`. 

<strong>2.</strong> When resolving the `DirectiveRegistry` the `blade-extensions` configuration is loaded into the registry.

```php
$directives->register($app['config']['blade-extensions.directives']);
$directives->setVersionOverrides($app['config']['blade-extensions.version_overrides']);
```

<strong>3.</strong> The `BladeExtensionsServiceProvider` adds a callback to `Application::booted` that executes `DirectiveRegistry@hookToCompiler()` 

<strong>4.</strong> The `hookToCompiler` method (by default) uses the `Illuminate\View\Compilers\BladeCompiler@extend` method, loops trough all directives and runs them using the `DirectiveRegistry->call($name, $params = [])` method.
```php
// in `Radic\BladeExtensions\DirectiveRegistry::hookToCompiler()` 
foreach ($this->getNames() as $name) {
   $this->getCompiler()->extend(function ($value) use ($name) {
       return $this->call($name, [$value]);
   });
}
```
  
<strong>5.</strong> The `DirectiveRegistry@call` method 'resolves' the directive if not already resolved, then calls it.
