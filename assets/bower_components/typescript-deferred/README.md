<a href="https://promisesaplus.com/">
    <img src="https://promisesaplus.com/assets/logo-small.png" alt="Promises/A+ logo"
         title="Promises/A+ 1.0 compliant" align="right" />
</a>

# What is it?

Typescript-Deferred is a tiny (3.3kB minified)
[Promises/A+](https://promisesaplus.com) compliant promise implementation
written in Typescript.

# Why?

There are many excellent promise implementations out there, and there is absolutely
no need for another one. Typescript-Deferred was created for the fun of it and
for getting a better grip on the Typescript typing system.

However, the result fully implements the spec, is small and has zero dependencies, so
it may be a good fit if you want to add A+ compliant promises to a
library or API without increasing the footprint. The code should work pretty much
everywhere, but I have not tested this extensively --- go ahead and tell
me if it breaks.

# How to use it?

## Packaging and loading.

Typescript-Deferred supports a variety of packaging options:

* **npm / browserify**: install from npm, require the module via
  `typescriptDeferred = require('typescript-deferred')`. The Typescript
  header is `typescript_deferred.d.ts`.
* **RequireJS / AMD**: Get `build/typescript_deferred.min.js` either via bower or
  from the github repo. This file is a UMD build that can be used with
  RequireJS and other AMD loaders. The Typescript header is `build/typescript_deferred.d.ts`
* **Plain script tag**: Get `build/typescript_deferred.min.js` either via bower or
  from the github repo. This UMD build can be loaded via script tag
  in the browser, the namespace is exported as `window.typescriptDeferred`. The
  corresponding Typescript header is `build/typescript_deferred_standalone.d.ts`.

As I am too lazy to type `typescriptDeferred`, we'll use `tsd` from now on.

## Creating deferreds and promises

Promises can be created either via `tsd.when()` or by creating a
deferred via `tsd.create()` and then accessing the promise controlled
by the deferred via the `promise` property.

### tsd.when

`when` wraps a value and returns a promise for that value. The argument may be either
a plain value or a promise / thenable. In case of a thenable, its state is adopted in
the way specified by the the Promises/A+ specs for `then` callback return values.

In Javascript, this looks like

    // A promise that resolves to 10
    var promise = tsd.when(10);

    // Adopting a thenable
    var promise = tsd.when(someThenable);

**Typescript**

In Typescript, the fully typed version of this code looks like

    // A promise for a number that resolves to 10
    var promise: tsd.PromiseInterface<number> =
        tsd.when<number>(10);

    // A promise that adops the state of some other thenable that wraps a value
    // of type sometype
    var promise: tsd.PromiseInterface<sometype> =
        tsd.when<sometype>(someThenable);
 
Note that `when` carries a type parameter that will be inferred automatically
by the compiler --- you won't have to specify it explicitly, even if the result
type is wrapped by a promise. In other words, a less verbose but working version
of the same example is

    var promise: tsd.PromiseInterface<number> =
        tsd.when(10);

    var promise: tsd.PromiseInterface<sometype> =
        tsd.when(someThenable);

### tsd.create

`create` creates a new deferred object. A deferred represents a promise which can
be either resolved via `deferred.resolve` or rejected via `deferred.reject`. The
promise can be acessed via the `promise` property on the deferred.

If the deferred is resolved with another thenable / deferred, its state is adopted
according the the Promises/A+ specs.

In Javascript, this looks like

    // Create a new deferred for a number
    var deferred = tsd.create();

    // Use the promise wrapped by the deferred
    deferred.promise.then(...);

    // Resolve the promise with a value...
    deferred.resolve(10);

    // ... or adopt another thenable ...
    deferred.resolve(someThenable);

    // ... or reject it with some reason
    deferred.reject(reason);

**Typescript**

In Typescript, the fully typed version of this code looks like

    // Create a new deferred for a number
    var deferred = tsd.create<number>();

    // Use the promise wrapped by the deferred, with the resolve / reject handlers
    // mapping to a type sometype
    deferred.promise.then<sometype>(...);

    // Resolve the promise with a value...
    deferred.resolve(10);

    // ... or adopt another thenable which wraps a value of type number ...
    deferred.resolve(someThenable);

    // ... or reject it with some reason (reasons are always type as any)
    deferred.reject(reason);

Again, the type parameter of `then` can be inferred by the compiler and left out
(see below).

## Using promises

The promises implemented by this package provide a `then` method that complies
with the Promises/A+ standard.

In **Typescript**, `then` is typed as a generic, taking the target type of
the callbacks as a type parameter which the compiler can infer from the callback type.
Type inference works regardless of whether the result type is wrapped by a promise
or not.

In addtion to then, two convenience methods `always` and `otherwise` are supplied.

### always

The code

    var foo = promise.always(callback);

is equivalent to

    var foo = promise.then(callback, callback);

**Typescript**

`always` can change the type wrapped by the promise and carries a type parameter
just like `then`.

### otherwise

The code

    var foo = promise.otherwise(callback);

is equivalent to

    var foo = promise.then(undefined, callback);

**Typescript**

`otherwise` cannot alter the type wrapped by the promise --- there is
no type parameter.

## More Typescript

Promises are described by the interface `tsd.PromiseInterface<sometype>` which
builds upon the thenable interface `tsd.ThenableInterface<sometype>`. If you
need to adopt foreign thenables that do not fully declare this interface (very
likely as it contains the necessary overloads to describe the different
invocations of `then`), you'll have to cast.

The full Typescript interface is described by the Typescript header `typescript_deferred.d.ts`.

### Warning: then vs. type safety

Using `then` to attach an error handler without providing a success handle
allows you to accidentially bypass Typescript's type system:

    // Create a new deferred for a string
    var deferred: tsd.DeferredInterface<string> = tsd.create();

    // Transform into a promise for a number
    var promise: tsd.PromiseInterface<number> =
        deferred.promise.then(undefined, () => 10);

    // Whoops, promise now wraps a string (contrary to its type!)
    deferred.resolve('foo');

The reason for this behavior is that `undefined` passes as a perfectly valid value for
`tsd.ImmediateSuccessCB<string, number>` but actually causes the string value to
propagate if the deferred is resolved.

Unfortunately, there is no way to avoid this trap without departing from the
Promises/A+ spec. If you want fully typed code without this kind of hidden
type violations, you should use the `otherwise` method described above if you
just want to attach an error handler. `otherwise` cannot change the type wrapped
by the promise. Note that using `then` to attach just a success handler or
both handler is fine and cannot lead to type violations.

# Building and Tests

In orde to build the code yourself, you need `grunt-cli` installed and `grunt` available
in your path.

The code can then be built and tested via

    > npm install
    > grunt initial
    > grunt build
    > grunt test

The testsuite runs the full Promises/A+ suite in its full 800+ test case glory and some
more tests for the additional functionality provided by this package.

# Can I use this in my project under license XYZ?

You like typescript-deferred? Awesome, go ahead, the code is available under the
MIT license.
