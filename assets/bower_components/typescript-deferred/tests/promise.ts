///<reference path="../typings/node/node.d.ts"/>
///<reference path="./interface/mocha.d.ts"/>

import tsd = require('../typescript_deferred');
import assert = require('assert');

suite('Extra promise utils', function() {

    this.timeout(100);

    suite('typescript-deferred.Promise::always', function() {

        test('callback is invoked upon resolution', function(done) {
            var deferred = tsd.create<number>();

            deferred.promise.always((): string => (done(), 'foo'));

            deferred.resolve(10);
        });

        test('callback is invoked upon rejection', function(done) {
            var deferred = tsd.create<void>();

            deferred.promise.always((): void => done());

            deferred.reject();
        });

    });

    suite('Promise::otherwise', function() {

        test('callback is invoked upon rejection', function(done) {
            var deferred = tsd.create<void>();

            deferred.promise.otherwise(() => done());

            deferred.reject();
        });

        test('callback is not invoked upon resolution', function(done) {
            var invoked = false,
                deferred = tsd.create<number>();
            
            deferred.promise.otherwise(function(): tsd.PromiseInterface<number> {
                invoked = true;

                done(new Error('callback was invoked!'));

                return tsd.when(10);
            });

            setTimeout(() => invoked ? undefined : done(), 50);

            deferred.resolve(10);
        });

    });

});
